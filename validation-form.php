
<!-- 
DB CONECTION -->

<!-- <?php
    if(isset($_POST['submit']))
    {
        $nombre       = $_POST['nombre'];
        $nation       = $_POST['nation'];
        $parcialidad  = $_POST['parcialidad'];
        $comunidad    = $_POST['comunidad'];
        $institucion  = $_POST['institucion'];
        $terminos     = $_POST['terminos'];
    }

        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cartografiaschaco.com";

        // creating a connection
        $con = mysqli_connect($host, $username, $password, $dbname);

       // to ensure that the connection is made
       if (!$con)
       {
        die("Connection failed!" . mysqli_connect_error());
       }

        // using sql to create a data entry query
        $sql = "INSERT INTO testing (id, nombre, nation, parcialidad, comunidad, institucion, terminos) VALUES ('0', '$nombre', '$nation', '$parcialidad', '$comunidad', '$institucion', '$terminos')";
  
        // send query to the database to add values and confirm if successful
         $rs = mysqli_query($con, $sql);
         if($rs)
        {
        echo "Entries added!";
       }
  
        // close connection
        mysqli_close($con);
?> -->



