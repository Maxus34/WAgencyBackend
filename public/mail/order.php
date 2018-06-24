<?php
    /** @var $order \app\models\records\OrderRecord */
    /** @var $items \app\models\records\OrderItemRecord[] */
?>

<div class="table-responsive">
    <table style="width: 100%; padding: 8px; border: 1px solid #ddd; border-collapse: collapse;">
        <tr>
            <th style="background: #f9f9f9; text-align: left; padding: 8px;">Имя</th>          <td><?=$order -> name?></td>
        </tr>
        <tr>
            <th style="background: #f9f9f9; text-align: left; padding: 8px;">Фамилия</th>      <td><?=$order -> surname?></td>
        </tr>
        <tr>
            <th style="background: #f9f9f9; text-align: left; padding: 8px;">Отчество</th>     <td><?=$order -> patronymic?></td>
        </tr>
        <tr>
            <th style="background: #f9f9f9; text-align: left; padding: 8px;">Ваш email</th>  <td><?=$order -> email?></td>
        </tr>
        <tr>
            <th style="background: #f9f9f9; text-align: left; padding: 8px;">Ваш телефон</th>  <td><?=$order -> phone?></td>
        </tr>
    </table>

    <hr>

    <table style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
        <thead>
        <tr style="background: #f9f9f9;">
            <th style="padding: 8px; border: 1px solid #ddd;">Наименование</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Кол-во</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Цена</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($items as $item):?>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item -> product -> name ?></td>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item -> qtyItems ?></td>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item -> product ->price ?> грн.</td>
            </tr>
        <?php endforeach?>
        <tr>
            <td colspan="2" style="padding: 8px; border: 1px solid #ddd;"><b>Итого: </b></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $order->qty ?></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 8px; border: 1px solid #ddd;"><b>На сумму:</b></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $order->sum ?></td>
        </tr>
        </tbody>
    </table>
    <p>
        Для вопросов или изменения заказа обратитесь к администратору <b>wagency.bot@mail.ru</b>
    </p>
</div>