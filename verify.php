<?php
    session_start();
    include('./connection.php');
    include('./data.php');
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    </head>
    <?php
    $name = $_SESSION['name'];
    $gender = $_SESSION['gender'];
    $faculty = $_SESSION['faculty'];
    $birthday = $_SESSION['birthday'];
    $address = $_SESSION['address'];
    $avatar = $_SESSION['avatar'];  

    if (isset($_POST['confirm'])) {
        $new = "INSERT INTO student(name, gender, faculty, birthday, address, avatar) VALUES('$name', '$gender', '$faculty', STR_TO_DATE('$birthday','%d/%m/%Y'), '$address', '$avatar')";
        if ($conn->query($new)) {
            header("Location: complete_regist.php");
        } 
    }
    ?>
    <body>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container">
                <div class="container__content">
                    <div class="form__item">
                        <label for="name" class="form__label">
                            Họ và tên
                        </label>
                        <div class="form__value">
                            <?php echo $name ?>
                        </div>
                    </div>
                    <div class="form__item">
                        <div class="form__label">
                            Giới tính
                        </div>
                        <div class="form__value">
                            <?php echo $genders[$gender] ?>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="faculty" class="form__label">
                            Phân khoa
                        </label>
                        <div class="form__value">
                            <?php echo $faculties[$faculty] ?>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="birthday" class="form__label">
                            Ngày sinh
                        </label>
                        <div class="form__value">
                            <?php echo $birthday ?>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="address" class="form__label">
                            Địa chỉ
                        </label>
                        <div class="form__value">
                            <?php echo $address ?>   
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="image" class="form__label">Hình ảnh</label>
                        <div class="form__value fomr__image">
                            <img class="image" src="<?php echo $avatar ?>" alt="">                            
                        </div>
                    </div>
                    <input type="submit" name = 'confirm' value="Xác nhận" class="form__submit">    
                </div>
            </div>
        </form>
    </body>
</html>
