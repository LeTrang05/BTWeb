<!DOCTYPE html>

<?php
    session_start();
    include('./connection.php');
    include ('./data.php');

    $is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <style>
        .form__search {
            padding: 60px;
        }
        .form__heading {
            width: 60%;
            margin: 0 auto 40px;

        }
        .form__item {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .form__label {
            min-width: 60px;
            color: #2f2e2f;
            font-weight: 500;
            display: inline-block;
        }
        .form__input {
            width: 100%;
            border: 1.5px solid #40719c;
            outline: none;
            border-radius: 2px;
            padding: 6px;
            background-color:#e1eaf4
        }
        .faculty {
            width: 100%;
            position: relative;
        }
        .form__faculty {
            appearance: none;
            cursor: pointer;
        }
        .focus {
            position: absolute;
            display: block;
            top: 75%;
            transform: translateY(-75%);
            right: 10px;
            border-width: 10px;
            border-style: solid;
            border-color: #2f75b6 transparent transparent;
        }
        .form__btn {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-left: 60px;
        }
        .form__submit {
            min-width: 120px;
            padding: 10px 30px;
            border-radius: 8px;
            background-color: #4e81bd;
            color: #fff;
            border: 3px solid #416c9f;
            cursor: pointer;
        }
        .form__add {
            float: right;
            margin:0 20px 20px;
        }
        .form__add-link {
            text-decoration:none;
            cursor: pointer;
            text-align: center;
            padding: 8px 20px;
            border-radius: 8px;
            background-color: #4e81bd;
            color: #fff;
            border: 3px solid #416c9f;
        }
        .form__table {
            width: 100%;
        }
        .form__col {
            text-align: left;
        }
        .form__row .form__col{
            padding-bottom: 20px;
            
        }
        .form__action {
            display: flex;
            gap: 10px;
        }
        thead .form__row .form__col:last-child{
            float: right;
            margin-right: 25%;
        }
        .form__action {   
            float: right;
        }
        .form__button {
            color: #fff;
            border: none;
            background-color:#8cabd0;
            padding: 8px 12px;
            border: 1px solid #416c9f;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
    <body>
        <form method="post" action="" class="form__search">
            <header class="form__heading">
                <div class="form__item">
                    <label for="faculty" class="form__label"> Khoa</label>
                    <div class="faculty">
                        <select id="faculty" name='faculty' class="form__input form__faculty">
                            <option value=""></option>
                            <?php
                                foreach($faculties as $faculty => $value) {
                                    echo "<option value= '". $faculty . "'";
                                    if(isset($_POST['search'])) {
                                        if ($is_page_refreshed){
                                            if (!empty($_POST['faculty'])) {
                                                $_SESSION['faculty'] = $_POST['faculty'];
                                                if ($faculty == $_SESSION['faculty']) {
                                                    echo "selected";   
                                                }
                                            }
                                        }
                                    }           
                                    echo ">$value</option>";
                                }
                            ?>
                        </select>
                        <span class="focus"></span>
                    </div>
                </div>
                <div class="form__item">
                    <label for="key" class="form__label">Từ khóa</label>
                    <input type="text" id="key" name="key" class="form__input" 
                    <?php
                        if(isset($_POST['search'])) {
                            if ($is_page_refreshed){
                                if (!empty($_POST['key'])) {    
                                    $_SESSION['key'] = $_POST['key'];
                                    echo "value='" . $_SESSION["key"] ."'";
                                }
                            }
                        }
                    ?>
                    >
                </div>
                <div class="form__btn">
                    <input type="submit" value="Xóa" name='remove' class="form__submit remove_btn">
                    <input type="submit" value="Tìm kiếm" name='search' class="form__submit search_btn">
                </div>
            </header>
            <div class="form__body">
                <div class="form__amount">
                    Số sinh viên tìm thấy:
                    <span class="form__amount-number">XXX</span>
                </div>
                <div class="form__add">
                    <a href="register.php" class="form__add-link">Thêm</a>
                </div>
                <table class="form__table">
                    <thead>
                        <tr class="form__row">
                            <th class="form__col">No</th>
                            <th class="form__col">Tên sinh viên</th>
                            <th class="form__col">Giới tính</th>
                            <th class="form__col">Khoa</th>
                            <th class="form__col">Ngày sinh</th>
                            <th class="form__col">Địa chỉ</th>
                            <th class="form__col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM student";
                    if (!empty($_POST['faculty'])) {
                        $sql = "SELECT * FROM student WHERE faculty = '" .  $_SESSION["faculty"] . "'" ;
                        if (!empty($_POST['key'])){
                            $sql .= " AND name LIKE '%" . $_SESSION["key"] . "%' OR address LIKE '%" . $_SESSION["key"] . "%'";
                        }
                    }
                    if (!empty($_POST['key'])){
                        $sql = "SELECT * FROM student WHERE name LIKE '%" . $_SESSION["key"] . "%' OR address LIKE '%" . $_SESSION["key"] . "%'";
                    }
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo '
                            <tr class="form__row">
                                <td class="form__col">' . $row["id"] . '</td>
                                <td class="form__col">' . $row["name"] . '</td>
                                <td class="form__col">' . $genders[$row['gender']] . '</td>
                                <td class="form__col">' . $faculties[$row['faculty']] .'</td>
                                <td class="form__col">' . $row["birthday"] . '</td>
                                <td class="form__col">' . $row["address"] . '</td>
                                <td class="form__col form__action">
                                    <input type="submit" value="Xóa" class=" form__remove form__button">
                                    <input type="submit" value="Sửa" class=" form__edit form__button">
                                </td>
                            </tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="./handle.js"></script>
    </body>
    
</html>
