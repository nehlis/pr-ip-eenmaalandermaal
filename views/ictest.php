<main role="main" class="container">
    <div class="row">
        <div class="col">
            <?php

            use App\Controllers\ItemController;
            use App\Core\Database;

            $ic = new ItemController();
            $db = new Database();


            try {
                $ic->handleSold($_POST['id'], 976, 99.99);
            } catch (Error $error) {
                $soldError = $error->getMessage();
            }

            try {
                $ic->increaseViews(31);
            } catch (Error $error) {
                $increaseError = $error->getMessage();
            }


            //try {
            //    $create = $ic->create([
            //        'Title' => 'Dit is een Test Item!',
            //        'Description' => 'Jajaja Hier kun je straks de beschrijving zien jonguh!',
            //        'City' => 'Arnhem',
            //        'CountryID' => 159,
            //        'StartingPrice' => 12.00,
            //        'StartDate' => '2020-11-10 12:47:43.000',
            //        'EndDate' => '2020-11-20 12:47:43.000',
            //        'PaymentMethod' => 'Ophalen',
            //        'PaymentInstructions' => 'Alleen OPHALEN!!!',
            //        'ShippingCosts' => 6.75,
            //        'SendInstructions' => null,
            //        'SellerID' => 1059,
            //        'ItemCategoryID' => 5
            //    ]);
            //} catch (Error $error) {
            //    $createError = $error->getMessage();
            // }

            try {
                $delete = $ic->delete(29);
            } catch (Error $error) {
                $deleteError = $error->getMessage();
            }

            try {
                $get = $ic->get(31);
            } catch (Error $error) {
                $getError = $error->getMessage();
            }

            try {
                $items = $ic->index();
            } catch (Error $error) {
                $indexError = $error->getMessage();
            }

            try {
                $featuredItems = $ic->getFeaturedItems(3);
            } catch (Error $error) {
                $customError = $error->getMessage();
            }

            try {
                $update = $ic->update(32, ['Title' => 'Aaaanpassinnggg!']);
            } catch (Error $error) {
                $updateError = $error->getMessage();
            }

            ?>
            <h1>Item Controller CRUD Operations Test</h1>
            <div class="row">
                <div class="col">
                    <h2>Create:</h2>
                    <div class="alert alert-danger <?= $createError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $createError ?? ''; ?>
                    </div>

                    <?php $create ? print_r($create) : "" ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Get:</h2>
                    <div class="alert alert-danger <?= $getError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $getError ?? ''; ?>
                    </div>

                    <?php $get ? print_r($get) : "" ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Delete:</h2>
                    <div class="alert alert-danger <?= $deleteError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $deleteError ?? ''; ?>
                    </div>

                    <?php $delete ? print_r($delete) : "" ?>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <h2>Update:</h2>
                    <div class="alert alert-danger <?= $updateError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $updateError ?? ''; ?>
                    </div>

                    <?php $update ? print_r($update) : "" ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Custom: </h2>

                    <div class="alert alert-danger <?= $customError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $customError ?? ''; ?>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($featuredItems as $item) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $item['ID'] ?></th>
                                        <td><?php echo $item['Title'] ?></td>
                                        <td><?php echo $item['Description'] ?></td>
                                        <td><?php echo $item['Views'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Index: </h2>

                    <div class="alert alert-danger <?= $indexError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $indexError ?? ''; ?>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">City</th>
                                    <th scope="col">CountryID</th>
                                    <th scope="col">StartingPrice</th>
                                    <th scope="col">StartDate</th>
                                    <th scope="col">EndDate</th>
                                    <th scope="col">PaymentMethod</th>
                                    <th scope="col">PaymentInstructions</th>
                                    <th scope="col">ShippingCosts</th>
                                    <th scope="col">SendInstructions</th>
                                    <th scope="col">SellerID</th>
                                    <th scope="col">BuyerID</th>
                                    <th scope="col">SellingPrice</th>
                                    <th scope="col">AuctionClosed</th>
                                    <th scope="col">ItemCategoryID</th>
                                    <th scope="col">Views</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $item['ID'] ?></th>
                                        <td><?php echo $item['Title'] ?></td>
                                        <td><?php echo $item['Description'] ?></td>
                                        <td><?php echo $item['City'] ?></td>
                                        <td><?php echo $item['CountryID']  ?></td>
                                        <td><?php echo $item['StartingPrice'] ?></td>
                                        <td><?php echo $item['StartDate'] ?></td>
                                        <td><?php echo $item['EndDate'] ?></td>
                                        <td><?php echo $item['PaymentMethod'] ?></td>
                                        <td><?php echo $item['PaymentInstructions'] ?></td>
                                        <td><?php echo $item['ShippingCosts'] ?></td>
                                        <td><?php echo $item['SendInstructions'] ?></td>
                                        <td><?php echo $item['SellerID'] ?></td>
                                        <td><?php echo $item['BuyerID'] ?></td>
                                        <td><?php echo $item['SellingPrice'] ?></td>
                                        <td><?php echo $item['AuctionClosed'] ?></td>
                                        <td><?php echo $item['ItemCategoryID'] ?></td>
                                        <td><?php echo $item['Views'] ?></td>
                                        <td>
                                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">

                                                <input type="hidden" name="id" value="<?= $item['ID'] ?>" />
                                                <button type="submit" <?= $item['AuctionClosed'] ? 'disabled' : '' ?> class="btn btn-<?= $item['AuctionClosed'] ? 'warning' : 'danger' ?> btn-sm" name="blocked" value='1'>
                                                    <i class="far fa-lg <?= $item['AuctionClosed'] ? 'fas fa-window-close' : 'fa-lock' ?>"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>