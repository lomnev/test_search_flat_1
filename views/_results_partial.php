<?php if(count($this->dataProvider) === 0) { ?>
    <h2 class="no_search_results">Нет результатов поиска</h2>
<?php } else { ?>
    <table class="results_table">
        <tr>
            <th>Комн.</th>
            <th>Адрес</th>
            <th>Метро</th>
            <th>Этаж</th>
            <th>Тип дома</th>
            <th>S (общ., жил., кух)</th>
            <th>С/у</th>
            <th>Субъект</th>
            <th>Контакт</th>
            <th>Доп. сведения</th>
            <th>Цена</th>
        </tr>

        <?php foreach($this->dataProvider as $result) { ?>
        <tr>
            <td><?=$result['flat_count']?></td>
            <td><?=$result['address']?></td>
            <td><?=$result['metro']?></td>
            <td><?=$result['floor']?></td>
            <td><?=$result['house_type']?></td>
            <td><?=$result['s_string']?></td>
            <td><?=$result['s_uzel']?></td>
            <td><?=$result['subject']?></td>
            <td><?=$result['contact']?></td>
            <td><?=$result['additional']?></td>
            <td><?=$result['price']?></td>
        </tr>
        <?php } ?>

    </table>
<?php } ?>

