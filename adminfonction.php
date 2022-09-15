<?php

function getCatOptions()
{

    global $con;
    $get_cat = "select * from categories";
    $run_cat = mysqli_query($con, $get_cat);

    while ($row_cat = mysqli_fetch_array($run_cat)) {
        $id_cat = $row_cat['cat_id'];
        $titre_cat = $row_cat['cat_title'];

        echo "<option value='$id_cat'>$titre_cat</option>";
    }
}

function getMarqueOption()
{
    global $con;
    $get_mar = "select * from marques";
    $run_mar = mysqli_query($con, $get_mar);

    while ($row_mar = mysqli_fetch_array($run_mar)) {
        $id_mar = $row_mar['mar_id'];
        $titre_mar = $row_mar['mar_title'];

        echo "<option value='$id_mar'>$titre_mar</option>";
    }
}

function insertProduct()
{
    global $con;
    if (isset($_POST['insert_prod'])) {

        $nom_produit = $_POST['nom_prod'];
        echo $nom_produit;
        $cat_produit = $_POST['cat_prod'];
        $marque_produit = $_POST['mar_prod'];
        $prix = $_POST['prix_prod'];
        $description = $_POST['desc_prod'];
        $mot_clé = $_POST['mc_prod'];
        $quantite_stock = $_POST['qt_stock'];
        $date = date('d-m-y h:i:s');
        $stars = $_POST['stars'];
        //Get image 

        $image_produit = $_FILES['image_prod']['name'];
        $image_produit_temp = $_FILES['image_prod']['tmp_name'];
        if (isset($image_produit)) {

            $insert_produit = "INSERT INTO `produits`(`cat_produit`, `marque_produit`, `nom_produit`, `prix_produit`, `description_produit`, `image_produit`, `mots-clef`,`vues`,`visible`,`date`,`stars`,`prix_solde`) VALUES('$cat_produit', '$marque_produit', '$nom_produit', '$prix', '$description', '$image_produit', '$mot_clé',0,'$quantite_stock','$date','$stars',0.00)";
            $query_prod = mysqli_query($con, $insert_produit);
            if ($query_prod) {
                move_uploaded_file($image_produit_temp, "image_produits/$image_produit");
                echo "<script>alert('Produit est Ajouté')</script>";
                echo "<script>window.open('index.php?action=produits','_self')</script>";
            }
        }
    }
}
function DeleteProduct()
{
    global $con;
    if (isset($_GET['id_prod_delete'])) {
        $get_product = mysqli_query($con, "SELECT * FROM produits WHERE `id_produit`=' $_GET[id_prod_delete]'");
        while ($row_prod = mysqli_fetch_array($get_product)) {
            $image_produit = $row_prod['image_produit'];
        }
        $delete_product = mysqli_query($con, "DELETE FROM `produits` WHERE `id_produit`=' $_GET[id_prod_delete]' ");
        if ($delete_product) {
            unlink("image_produits/$image_produit");
            echo "<script>alert('Produit est Supprimé')</script>";
            echo "<script>window.open('index.php?action=produits','_self')</script>";
        }
    }
}
function DeleteCat()
{
    global $con;
    if (isset($_GET['id_cat_delete'])) {
        $get_cat = mysqli_query($con, "SELECT * FROM categories WHERE `cat_id`=' $_GET[id_cat_delete]'");
        $delete_cat = mysqli_query($con, "DELETE FROM `categories` WHERE `cat_id`=' $_GET[id_cat_delete]' ");
        if ($delete_cat) {
            echo "<script>alert('Categories est Supprimé')</script>";
            echo "<script>window.open('index.php?action=categorie','_self')</script>";
        }
    }
}
function Deletemar()
{
    global $con;
    if (isset($_GET['id_mar_delete'])) {
        $get_mar = mysqli_query($con, "SELECT * FROM marques WHERE `mar_id`=' $_GET[id_mar_delete]'");
        $delete_mar = mysqli_query($con, "DELETE FROM `marques` WHERE `mar_id`=' $_GET[id_mar_delete]' ");
        if ($delete_mar) {
            echo "<script>alert('marque est Supprimé')</script>";
            echo "<script>window.open('index.php?action=marque','_self')</script>";
        }
    }
}
function DeleteAllProduct()
{
    global $con;
    if (isset($_POST['deleteAll'])) {
        $remove = $_POST['deleteAll'];
        foreach ($remove as $key) {
            $get_product = mysqli_query($con, "SELECT * FROM produits WHERE `id_produit`='$key'");
            while ($row_prod = mysqli_fetch_array($get_product)) {
                $image_produit = $row_prod['image_produit'];
            }
            $run_remove = mysqli_query($con, "DELETE FROM `produits` WHERE `id_produit`='$key'");
            if ($run_remove) {
                unlink("image_produits/$image_produit");
                echo "<script>alert('Produits sélectionnés Sont Supprimés')</script>";
                echo "<script>window.open('index.php?action=produits','_self')</script>";
            }
        }
    }
}

function PrixSolde()
{
    global $con;
    if (isset($_POST['update_prod'])) {
        if (isset($_GET['id_prod_edit'])) {
            $prix = $_POST['prix'];
            $pourcentage = $_POST['solde'];
            $prix_solde = $prix - ($prix * $pourcentage / 100);
            $update_product = mysqli_query($con, "UPDATE `produits` SET `prix_produit`=$prix, `prix_solde`='$prix_solde' WHERE `id_produit`='$_GET[id_prod_edit]' ");
            if ($update_product) {

                echo "<script>alert('Produit est Modifié')</script>";
                echo "<script>window.open('index.php?action=produits','_self')</script>";
            }
        }
    }
}
function insertCat()
{
    global $con;
    if (isset($_POST['insert_cat'])) {

        $nom_cat = $_POST['nom_cat'];
        $insert_cat = "INSERT INTO `categories` (`cat_title`) VALUES ('$nom_cat')";
        $query_cat = mysqli_query($con, $insert_cat);
        if ($query_cat) {
            echo "<script>alert('Catégorie est Ajoutée ')</script>";
            echo "<script>window.open('index.php?action=categorie','_self')</script>";
        }
    }
}
function insertMark()
{
    global $con;
    if (isset($_POST['insert_mark'])) {

        $nom_mark = $_POST['nom_mark'];
        $insert_mark = "INSERT INTO `marques`(`mar_title`) VALUES ('$nom_mark')";
        $query_mark = mysqli_query($con, $insert_mark);
        if ($query_mark) {
            echo "<script>alert('Marque est Ajoutée ')</script>";
            echo "<script>window.open('index.php?action=marque','_self')</script>";
        }
    }
}
