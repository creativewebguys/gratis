<div class="col-lg-12">
    <h1>Admin Dashboard</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($params['data'] as $row) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><a href="<?= SITEURL .'/?page=editcar&id=' .$row['id'] ?>" class="btn btn-small btn-primary">Edit</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>