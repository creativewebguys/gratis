<div class="col-lg-10 px-0 row">
    <?php if($params[0]['count'] > 0) { foreach($params[0]['data'] as $row) { ?>
    <div class="col vehicle-inventory-container">
        <div class="ibox">
            <div class="productimage">
                <a href="<?= SITEURL .'/?page=details&id=' .$row['id'] ?>"><img src="<?= SITEURL .'/images/' .$row['screenshot'] ?>"></a>
                <span class="productprice">$<?= number_format($row['dealerprice'], 2, '.', ',') ?></span>
            </div>
            <div class="productdetails">
                <a href="<?= SITEURL .'/?page=details&id=' .$row['id'] ?>" class="productname"><?= $row['name'] ?></a>
                <div class="small m-t-xs">
                    <div class="row">
                        <div class="col">
                            Condition: 
                        </div>
                        <div class="col">
                            <?= $row['condition'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Retail Price: 
                        </div>
                        <div class="col">
                            $<?= number_format($row['retailprice'], 2, '.', ',') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Stock #: 
                        </div>
                        <div class="col">
                            <?= $row['stocknumber'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Mileage: 
                        </div>
                        <div class="col">
                            <?= $row['mileage'] ?>
                        </div>
                    </div>
                </div>
                <div class="productbtn">
                    <a href="<?= SITEURL .'/?page=details&id=' .$row['id'] ?>" class="btn btn-small btn-secondary">Details</a>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>
</div>