<?php
/**
 * @var string $errorMessage;
 * @var string $successMessage;
 */
?>
<h3>Add link to share</h3>

<?php if (!empty($resultLinks)):?>
    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
        <ul>
            <?php foreach ($resultLinks as $label => $link): ?>
                <li><?=$label?>:<a href="<?=$link;?>"><b> <?=$link;?></b></a></li>
            <?php endforeach?>
        </ul>
    </div>
<?php endif;?>
<form method="POST" action="?">
    <div class="form-group<?=$errorMessage ? ' has-error' : '';?>">
        <label> Enter link </label>
            <input
                type="text"
                class="form-control"
                name="url"
                value="<?=$url?>"
            />
        <?php if($errorMessage):?>
            <div class="control-label">
                <?=$errorMessage;?>
            </div>
        <?php endif;?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>