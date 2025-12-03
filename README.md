# Latihan OOP PHP


Halo halo, Sekarang disini akan mencoba menggunakan PHP dengan OOP.
Cek juga repo lain nya:
 [Html dasar](https://github.com/laLafid/Lab1Web), [CSS dasar](https://github.com/laLafid/lab2web), [CSS](https://github.com/laLafid/Lab3Web), [CSS Layout](https://github.com/laLafid/Lab4Web), [Dasar Javascript](https://github.com/laLafid/Lab5Web), [Dasar Bootstarp](https://github.com/laLafid/Lab6Web), [Dasar PHP](https://github.com/laLafid/Lab7Web), [CRUD PHP](https://github.com/laLafid/Lab8Web) dan [Modular PHP](https://github.com/laLafid/Lab9Web).


## Langkah-langkah

1. **Persiapan**
    - Editornya, misal Visual Studio Code.
    ![alt text](gambar/vs.png)
    
    - XAMPP, kalo belum punya unduh dulu di [sini](https://www.apachefriends.org/).

    - Buka XAMPP control panel dulu, aktifin ``apache`` dan ``mysql`` lalu pencet admin dibagian ``mysql`` buat masuk ke phpmyadmin.
    ![alt text](gambar/Bukaxxamp.png)

    - Pake Database sebelumnya, kalo belum punya cek [CRUD PHP](https://github.com/laLafid/Lab8Web)

    - Koneksi Database pake PHP

    ![alt text](gambar/2.0.png)
    
    ``koneksi.php`` sekarang jadi tempat nyimpen aja.
    ```php
    $config = [
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'db_name'   => 'latihan1',
    ];
    ```

    - jangan lupa ya file dan folder nya seperti ini:

    ![alt text](gambar/file.png)




2. **Ada beberapa tambahan dan perubahan dari yang sebelumnya:**

    - Untuk menuju OOP, gajah.php(database) akan diisi dengan class database?
    ```php
    define('ROOT', __DIR__ . '/../');                   
    define('CONFIG', ROOT . 'config/');
    define('GAMBAR', ROOT . 'gambar/');
    define('BASE_URL', 'http://localhost/webpro10/');         // ganti kalo error
    class Database
    {
        protected $host;
        protected $user;
        protected $password;
        protected $db_name;
        public $conn;
        public function __construct()
        {
            $this->getConfig();
            $this->conn = new mysqli( $this->host, $this->user, $this->password, $this->db_name );
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        private function getConfig()
        {
            include_once("koneksi.php"); 
            $this->host = $config['host'];
            $this->user = $config['username'];
            $this->password = $config['password'];
            $this->db_name = $config['db_name'];
        }
        public function query($sql) 
        {
            return $this->conn->query($sql);
        }
        public function get($table, $where = null) // dipakai untuk buat table di home.php
        {
            if ($where) {
                $where = " WHERE " . $where;
            }
            $sql = "SELECT * FROM " . $table . $where;
            $result = $this->conn->query($sql);
            return $result;
        }
        public function insert($table, $data) // ini untuk tambah.php 
        {
            if (is_array($data)) {
                foreach ($data as $key => $val) {
                    $column[] = $key;
                    $value[] = "'{$val}'";
                }
                $columns = implode(",", $column);
                $values = implode(",", $value);
            }
            $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
            $sql = $this->query($sql); 
            if ($sql == true) {
                return $sql;
            } else {
                return false;
            }
        }
        public function update($table, $data, $where) // edit.php
        {
            $update_value = [];
            if (is_array($data)) {
                foreach ($data as $key => $val) {
                    $update_value[] = "$key='{$val}'";
                }
                $update_value = implode("," ,$update_value);
            }
            $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
            $sql = $this->query($sql);
            if ($sql == true) {
                return true;
            } else {
                return false;
            }
        }
        public function delete($table, $filter) // tahu
        {
            $sql = "DELETE FROM " . $table . " " . $filter;
            $sql = $this->query($sql);
            if ($sql == true) {
                return true;
            } else {
                return false;
            }
        }
    }
    $db = new Database(); // ini buat nanti dipanggil
    ```

    - nambah 1 file juga ``form.php`` , tugasnya buat bikin kolom form
    ```php
    class Form
    {
        private $fields = array();
        private $action;
        private $submit = "Submit Form";
        private $jumField = 0;
        private $enctype = false;
        public function __construct($action, $submit, $enctype = false)
        { $this->action=$action; $this->submit=$submit; $this->enctype=$enctype;}
        
        public function displayForm()
        {
            $enc = $this->enctype ? "enctype='multipart/form-data'" : "";
            echo "<form action='" . $this->action . "' method='POST' $enc>";
            echo '<table width="100%" border="0">';

            for ($j = 0; $j < count($this->fields); $j++) {
                $field = $this->fields[$j];
                echo "<tr><td align='right'>{$field['label']}</td><td>";
                if ($field['type']=='select'){ echo "<select name='{$field['name']}'>"; foreach ($field['options'] as $val=>$text){ $selected=($val==$field['value']) ? 'selected' : ''; echo "<option value='$val' $selected>$text</option>";} echo "</select>";}
                elseif ($field['type']=='file'){ echo "<input type='file' name='{$field['name']}'>";}
                else{ $type=$field['type'] ?? 'text'; $value=htmlspecialchars($field['value'] ?? ''); echo "<input type='$type' name='{$field['name']}' value='$value'>";}
                echo "</td></tr>";
            }

            echo "<tr><td colspan='2'>";
            echo "<input type='submit' name='submit' value='" . $this->submit . "'></td></tr>";
            echo "</table></form>";
        }
        
        public function addField($name, $label)
        { $this->fields[$this->jumField]['name']=$name; $this->fields[$this->jumField]['label']=$label; $this->jumField++;}
        
        public function addText($name, $label, $value = '', $type = 'text')
        { $this->fields[]=['name'=>$name, 'label'=>$label, 'value'=>$value, 'type'=>$type];}
        
        public function addSelect($name, $label, $options, $selected = '')
        { $this->fields[]=['name'=>$name, 'label'=>$label, 'type'=>'select', 'options'=>$options, 'value'=>$selected];}
        
        public function addFile($name, $label)
        { $this->fields[]=['name'=>$name, 'label'=>$label, 'type'=>'file'];}

        public function addTextarea($name, $label, $value = '', $rows = 4)
        { $this->fields[]=[ 'name'=>$name, 'label'=>$label, 'type'=>'textarea', 'value'=>$value, 'rows'=>$rows ];}
    }
    ```

    - nih contoh penggunaan class yang baru ada di ``ubah.php``
    ```php
    <?php
    error_reporting(E_ALL);
    require_once __DIR__ . '/../../config/gajah.php';
    require ROOT . 'view/header.php';
    require_once ROOT . 'module/clank/form.php';

    if ($_POST) { // ada perubahan juga disini, but tidak begitu berbeda
        $id = $_POST['id'];
        $data = [
            'nama'       => $_POST['nama'],
            'kategori'   => $_POST['kategori'],
            'harga_jual' => $_POST['harga_jual'],
            'harga_beli' => $_POST['harga_beli'],
            'stok'       => $_POST['stok'],
        ];
        if (!empty($_FILES['file_gambar']['name']) && $_FILES['file_gambar']['error'] == 0) {
            $filename = str_replace(' ', '_', $_FILES['file_gambar']['name']);
            $destination = GAMBAR . $filename;
            if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
                $data['gambar'] = 'gambar/' . $filename;

                $old = $db->get('data_barang', "id_barang = '$id'")->fetch_assoc();
                if (!empty($old['gambar']) && file_exists(GAMBAR . basename($old['gambar']))) {
                    unlink(GAMBAR . basename($old['gambar']));
                }
            }
        }
    // make modul update
        $db->update('data_barang', $data, "id_barang = '$id'");
        header('Location: ' . BASE_URL . 'view/home.php');
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $result = $db->get('data_barang', "id_barang = '$id'"); // make modul get
    $data = $result->fetch_assoc();

    if (!$data) {
        die('Data tidak ditemukan!');
    }
    ?>

    <div class="container">
        <h1>Ubah Barang</h1>
    // pake function/modul yang ada di form.php
        <?php
        $form = new Form("", "Update Barang", true);
        $form->addText("id", "", $data['id_barang'], "hidden");
        $form->addText("nama",       "Nama Barang",      $data['nama']);
        $form->addSelect("kategori", "Kategori", [
            "Komputer"   => "Komputer",
            "Elektronik" => "Elektronik",
            "Hand Phone" => "Hand Phone"
        ], $data['kategori']);
        $form->addText("harga_jual", "Harga Jual",       $data['harga_jual']);
        $form->addText("harga_beli", "Harga Beli",       $data['harga_beli']);
        $form->addText("stok",       "Stok",             $data['stok']);
        $form->addFile("file_gambar","Ganti Gambar (kosongkan jika tidak diganti)");

        $form->displayForm();
        ?>

        <br>
        <a href="<?= BASE_URL ?>view/home.php" class="btn">Kembali</a>
    </div>

    <?php require ROOT . 'view/footer.php'; ?>
    ```

    - Update dari repo sebelumnya, semua tombol dah bisa dipencet dan berfungsi sewajarnya. 


3. **Hasil Akhir**

    Tampilan setelah diberi css(ada yang belum), yang sebelumnya diganti 😗 jadi lebih comfy.
    
    ![alt text](gambar/3.1.png)

    ![alt text](gambar/3.0.png)

    ![alt text](gambar/3.2.png)
    
    ![alt text](gambar/3.3.png)

    
## Akhri Kata


*Selamat mencoba*
