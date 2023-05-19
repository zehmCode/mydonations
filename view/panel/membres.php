<?php $title = "Panel - MyDonations";
ob_start();
?>

<?php include 'partials/_panelNavbar.php' ?>

<!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Membres inscrit</h2>
        <div class="row">
            <div class="col-md-12">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Avatar</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rang</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user){ ?>
                        <tr>
                            <th scope="row"><img src="../<?php echo $user['avatar'] ?>"  width=40 height=40 alt=""></th>
                            <td><?= $user['first_name'] ?></td>
                            <td><?= $user['last_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>
                                <?php echo ($user['rank'] > 0) ? "<div class=\"badge badge-danger\">ADMIN</div>" : "<div class=\"badge badge-primary\">MEMBRE</div>"; ?>
                            </td>
                            <td>
                                <form action="" method="POST" class="d-flex" style="gap: 5px;">
                                    <select class="form-control form-control-lg">
                                        <option selected>changer le rang</option>
                                        <option value="1">ADMIN</option>
                                        <option value="0">MEMBRE</option>
                                    </select>
                                    <button type="submit" class="btn btn-success"><i class="fa-regular fa-circle-check"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                    if ($totalPages > 1) {
                        // Display the previous page link
                        if ($pageNumber > 1) {
                            echo '<a class="btn btn-primary" href="membres&page=' . ($pageNumber - 1) . '">Previous</a>';
                        }
                        
                        // Display the first page link
                        if ($pageNumber > 3) {
                            echo '<a class="btn btn-primary" href="membres&page=1">1</a>';
                            if ($pageNumber > 5) {
                                echo '<span class="ellipsis">...</span>';
                            }
                        }
    
                        // Display the page links
                        for ($i = max(1, $pageNumber - 2); $i <= min($pageNumber + 2, $totalPages); $i++) {
                            if ($i == $pageNumber) {
                                echo '<a class="active btn btn-primary">' . $i . '</a>';
                            } else {
                                echo '<a class="btn btn-primary" href="membres&page=' . $i . '">' . $i . '</a>';
                            }
                        }
    
                        // Display the last page link
                        if ($pageNumber < $totalPages - 2) {
                            if ($pageNumber < $totalPages - 3) {
                                echo '<span class="ellipsis">...</span>';
                            }
                            echo '<a class="btn btn-primary" href="membres&page=' . $totalPages . '">' . $totalPages . '</a>';
                        }
    
                        // Display the next page link
                        if ($pageNumber < $totalPages) {
                            echo '<a class="btn btn-primary" href="membres&page=' . ($pageNumber + 1) . '">Next</a>';
                        }
                    }
                    echo '</div>';
                ?>
            </div>
        </div>
      </div>
</div>


<?php $content=ob_get_clean();?>
<?php require('templatePanel.php');?>