<?php if(count($params) > 0) { $data = $params[0] ?>
<div class="col-lg-10 px-0 row"><h1><?= $data[0]['name'] ?></h1></div>
<div class="col-lg-10 px-0 row">
    <div class="col">
        <div id="productcarousel" class="carousel slide">
            <div class="carousel-inner">
                <?php $ii=1; foreach($data as $row) { ?>
                <div class="carousel-item<?= ($ii == 1) ? ' active' : '' ?>">
                <img src="<?= SITEURL .'/images/' .$row['image'] ?>" class="d-block w-100">
                </div>
                <?php $ii++; } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productcarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productcarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="bold">
            <h1>Options & Features</h1>
        </div>

        <table class="table table-striped">
            <tbody>
                <?php foreach($params[1] as $row) { ?>
                <tr>
                    <td>
                        <?= $row['meta_value'] ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col">
        <h3 class="details_pricingdetails font-weight-bold">Pricing Details</h3>
        <div class="row">
            <div class="col">
                <h4>Retail Price: </h4>
            </div>
            <div class="col">
                <h4>$<?= number_format($data[0]['retailprice'], 2) ?></h4>
            </div>
        </div>
        <hr class="border border-secondary border-2 opacity-50">
        <div class="row">
            <div class="col">
                <h3>Dealer Price: </h3>
            </div>
            <div class="col">
                <h3>$<?= number_format($data[0]['dealerprice'], 2) ?></h3>
            </div>
        </div>
    </div>
</div>
<?php } else { echo '<h1>Invalid Car ID</h1>'; } ?>