<main role="main" class="container">
    <div class="row">
        <div class="col">
            <?php

            use App\Controllers\CategoriesByItemController;
            use App\Controllers\ItemController;
            use App\Core\Database;

            $ic = new ItemController();
            $cbic = new CategoriesByItemController();
            $db = new Database();


            var_dump($_POST);
            echo '<br>';
            var_dump($_FILES);


            if(isset($_FILES['image'])){
                $errors= array();
                $file_name = str_replace(' ', '_', $_FILES['image']['name']);
                $file_size =$_FILES['image']['size'];
                $file_tmp =$_FILES['image']['tmp_name'];
                $file_type=$_FILES['image']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
                $file_name = date("Ymdhis")."_".$file_name;
                
                $extensions= array("jpeg","jpg","png");
                
                if(in_array($file_ext,$extensions)=== false){
                   $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }
                
                if($file_size > 2097152){
                   $errors[]='File size must be excately 2 MB';
                }
                
                if(empty($errors)==true){
                   move_uploaded_file($file_tmp,"upload/".$file_name);
                   echo "Success";
                }else{
                   print_r($errors);
                }
             }
            // try {
            //     $ic->handleSold($_POST['id'], 976, 99.99);
            // } catch (Error $error) {
            //     $soldError = $error->getMessage();
            // }

            // try {
            //     $ic->increaseViews(31);
            // } catch (Error $error) {
            //     $increaseError = $error->getMessage();
            // }


            // try {
            //     $create = $ic->create([
            //         'Title' => 'Dit is een Test Item!',
            //         'Description' => 'Jajaja Hier kun je straks de beschrijving zien jonguh!',
            //         'City' => 'Arnhem',
            //         'CountryID' => 159,
            //         'StartingPrice' => 12.00,
            //         'StartDate' => '2020-11-10 12:47:43.000',
            //         'EndDate' => '2020-11-20 12:47:43.000',
            //         'PaymentMethod' => 'Ophalen',
            //         'PaymentInstructions' => 'Alleen OPHALEN!!!',
            //         'ShippingCosts' => 6.75,
            //         'SendInstructions' => null,
            //         'SellerID' => 1059
            //     ]);
            // } catch (Error $error) {
            //     $createError = $error->getMessage();
            // }

            // try {
            //     $addCategoriesInItem = $cbic->create([
            //         'ItemID' => $create['ID'],
            //         'CategoryID' => 3736
            //     ]);
            //  } catch (Error $error) {
            //     $addCategoriesInItemError = $error->getMessage();
            //  }

            // try {
            //     $delete = $ic->delete(29);
            // } catch (Error $error) {
            //     $deleteError = $error->getMessage();
            // }

            // try {
            //     $items = $ic->get(31);
            // } catch (Error $error) {
            //     $getError = $error->getMessage();
            // }

            // try {
            //     $items = $ic->getMax(3);
            // } catch (Error $error) {
            //     $indexError = $error->getMessage();
            // }

            // try {
            //     $featuredItems = $ic->getFeaturedItems(3);
            // } catch (Error $error) {
            //     $customError = $error->getMessage();
            // }

            // try {
            //     $update = $ic->update(32, ['Title' => 'Aaaanpassinnggg!']);
            // } catch (Error $error) {
            //     $updateError = $error->getMessage();
            // }

            ?>
            <h1>Item Controller CRUD Operations Test</h1>
            <div class="row">
                <div class="col">
                    <h2>Upload file</h2>
                    <form action="/ictest" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="image" id="image">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>