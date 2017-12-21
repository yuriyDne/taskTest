<?php
/**
 * @var \Dto\LinkShorterDto $link
 * @var array $viewData
 */
?>
<h3>Link visit statistic</h3>

<b>Url:</b> <?=$link->getLink();?><br />
<table class="table table-striped">
    <tr>
        <th>
            Date
        </th>
        <th>
            Views count
        </th>
        <th>Action</th>
    </tr>
    <?php foreach($viewData as $item): ?>
        <tr>
            <td><?=$item['created_date'];?></td>
            <td><?=$item['views_count'];?></td>
            <td>
                <a href="<?=$linkUrl?>?date=<?=$item['created_date'];?>">View</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>