<?php
/**
 * @var \Dto\LinkShorterDto $link
 * @var \Dto\LinkStatisticDto[] $viewData
 */
?>
<h3>Daily statistic statistic</h3>

<b>Url:</b> <?=$link->getLink();?><br />
<a href="<?=$backUrl?>">Back</a>

<table class="table table-striped">
    <tr>
        <th>Visit time</th>
        <th>ip</th>
        <th>Location</th>
        <th>Browser Name</th>
        <th>Browser Version</th>
        <th>Operation System</th>
    </tr>
    <?php foreach($viewData as $item): ?>
        <tr>
            <td><?=$item->getDate()->format('Y-m-d H:i:s');?></td>
            <td><?=$item->getIp();?></td>
            <td><?=$item->getLocation();?></td>
            <td><?=$item->getBrowserName();?></td>
            <td><?=$item->getBrowserVersion();?></td>
            <td><?=$item->getOperationSystem();?></td>
        </tr>
    <?php endforeach;?>
</table>