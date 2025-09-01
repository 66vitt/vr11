<div>
    <table class="table">
        <thead>
        <tr>
            <th scope="row">Количество заказов</th>
            <th scope="row">Начисленная зарплата</th>
            <th scope="row">Расходы</th>
            <th scope="row">Полученная сумма</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ array_sum($weeklyReport[0]['values']) }}</td>
            <td>{{ array_sum($weeklyReport[1]['values']) }}</td>
            <td>{{ array_sum($weeklyReport[2]['values']) }}</td>
            <td>{{ array_sum($weeklyReport[3]['values']) }}</td>
        </tr>
        </tbody>
    </table>
</div>
