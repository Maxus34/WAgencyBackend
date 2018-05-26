<?php

namespace app\models;

use Yii;
use Firebase\JWT\JWT;
use yii\db\{ Expression, ActiveRecord };
use yii\web\{ Request as WebRequest, IdentityInterface };
use yii\behaviors\{ TimestampBehavior, BlameableBehavior };

/**
 * Class User
 *
 * @property integer $id
 * @property string  $email
 * @property string  $name
 * @property string  $surname
 * @property string  $patronymic
 * @property integer $role
 * @property integer $status
 * @property string  $passwordHash
 * @property string  $passwordResetToken
 * @property string  $emailConfirmToken
 * @property integer $createdAt
 * @property integer $createdBy
 * @property integer $updatedAt
 * @property integer $updatedBy
 * @property integer $lastLoginAt
 * @property string  $lastLoginIp
 *
 * @package app\models
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_USER  = 'Role[user]';
    const ROLE_ADMIN = 'Role[admin]';

    const TOKEN_ENCRYPTING_ALG = 'HS256';

    /** @var  array $permissions to store list of permissions */
    public $permissions;

    /** @var  string $accessToken to store JWT*/
    public $accessToken;

    /** @var  array  JWT token*/
    protected static $decodedToken;


    public static function tableName() {
        return 'user';
    }


    public static function findIdentity ($id) {
        return static::findOne(['id' => $id]);
    }


    public static function findByEmail ($email) {
        return static::findOne(['email' => $email]);
    }


    /**
     * Finds User by decoded AccessToken
     * @param string $accessToken
     * @param null $type
     * @return bool|null|\yii\web\IdentityInterface|static
     */
    public static function findIdentityByAccessToken ($accessToken, $type = null) {
        $secret = static::getJWTSecretCode();

        try{
            $decoded = JWT::decode($accessToken, $secret, [static::TOKEN_ENCRYPTING_ALG]);
        } catch (\Exception $e) {
            return false;
        }

        static::$decodedToken = (array) $decoded;

        if (!isset(static::$decodedToken['jti'])){
            return false;
        }

        $id = static::$decodedToken['jti'];
        return static::findIdentity($id);
    }


    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function rules () {
        return [
            [
                ['email'],
                'required',
                'message' => Yii::t("app", Yii::t('app', "Field cannot be blank"))
            ],
            [
                'email', 'string', 'max' => 255
            ],
            ['email', 'email'],
            ['emailConfirmToken', 'default', 'value' => $this->generateEmailConfirmToken()],
            ['passwordHash', 'default', 'value' => $this->generatePassword()]
        ];
    }


    public function fields () {
        $fields = parent::fields();

        if (YII_DEBUG) {
            return $fields;
        }

        unset(
            $fields['passwordHash'],
            $fields['passwordResetToken'],
            $fields['emailConfirmToken']
        );

        return $fields;
    }


    public function extraFields()
    {
        $ef = parent::extraFields();

        $ef[] = 'roles';

        return $ef;
    }


    public function behaviors () {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdBy', 'updatedBy'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedBy']
                ]
            ]
        ];
    }


    public function getId () {
        return $this->id;
    }


    public function getAuthKey () {
        return null;
    }


    public function validateAuthKey ($authKey) {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * Validates password
     * @param $password
     * @return bool
     */
    public function validatePassword ($password) {
        return \Yii::$app->security->validatePassword($password, $this->passwordHash);
    }


    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword ($password) {
        $this->passwordHash = \Yii::$app->security->generatePasswordHash($password);
    }


    public function getRoles () {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }


    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePassword () {
        return Yii::$app->security->generateRandomString();
    }


    /**
     * Generates a new password reset token(with creation date)
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken () {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     *  Sets passwordResetToken = null
     */
    public function removePasswordResetToken () {
        $this->passwordResetToken = null;
    }


    /**
     * Finds user by password reset token
     * @param $token
     * @return null|static
     */
    public static function findByPasswordResetToken ($token) {
        if ( !self::isPasswordResetTokenNotExpired($token) ){
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token
        ]);
    }


    /**
     * Checks that password reset token is not expired
     * @param $token
     * @return bool
     */
    public static function isPasswordResetTokenNotExpired ($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }


    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateEmailConfirmToken () {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }


    public static function isEmailConfirmTokenNotExpired ($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = \Yii::$app->params['user.emailConfirmTokenExpire'];

        return $timestamp + $expire >= time();
    }


    public static function findByEmailConfirmToken ($token) {
        if ( !static::isEmailConfirmTokenNotExpired($token) ){
            return null;
        }

        return static::find()->where([
            'emailConfirmToken' => $token,
        ])->one();
    }


    /**
     *  Creates a JWT token and log login date with login IP
     */
    public function generateAccessTokenAfterLogin () {
        $this->lastLoginIp = Yii::$app->request->userIP;
        $this->lastLoginAt = new Expression("NOW()");
        $this->save(false);

        $tokens = $this->getJWT();
        $this->accessToken= $tokens[0];
    }


    /**
     * Creates a custom JWT with user model id set in it
     * @return array encoded JWT
     */
    public function getJWT () {
        // Collect all the data
        $secret      = static::getJWTSecretCode();
        $currentTime = time();
        $expire      = $currentTime + 86400; // 1 day
        $request     = \Yii::$app->request;
        $hostInfo    = '';
        // There is also a \yii\console\Request that doesn't have this property
        if ($request instanceof WebRequest) {
            $hostInfo = $request->hostInfo;
        }

        // Merge token with presets not to miss any params in custom
        // configuration
        $token = array_merge([
            'jti' => $this->getId(),    // JSON Token ID: A unique string, could be used to validate a token, but goes against not having a centralized issuer authority.
            'iat' => $currentTime,      // Issued at: timestamp of token issuing.
            'iss' => $hostInfo,         // Issuer: A string containing the name or identifier of the issuer application. Can be a domain name and can be used to discard tokens from other applications.
            'aud' => $hostInfo,
            'nbf' => $currentTime,      // Not Before: Timestamp of when the token should start being considered valid. Should be equal to or greater than iat. In this case, the token will begin to be valid 10 seconds
            'exp' => $expire,           // Expire: Timestamp of when the token should cease to be valid. Should be greater than iat and nbf. In this case, the token will expire 60 seconds after being issued.
            'data' => [
                'lastLoginAt'   =>  $this->lastLoginAt,
            ],
            'model' => $this->toArray()
        ], []);

        return [JWT::encode($token, $secret, static::TOKEN_ENCRYPTING_ALG), $token];
    }


    /** returns JWT secret key */
    public static function getJWTSecretCode () {
        return \Yii::$app->params['jwtSecretCode'];
    }

}
