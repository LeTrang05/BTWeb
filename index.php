<?php
    session_start();
    include ('./data.php');
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
    <body>
        <?php  
            $name = $gender = $faculty = $birthday = $address = $file = "";
            $nameErr = $genderErr = $facultyErr = $birthdayErr = $imageErr = "";
            $numErr = 0;
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (empty($_POST["name"])) {
                    $nameErr = "Hãy nhập tên.";
                    $numErr++;
                } else {
                    $name = test_input($_POST["name"]);
                    $_SESSION['name'] = $name;
                }
                if (!isset($_POST["gender"])) {
                    $genderErr = "Hãy chọn giới tính." ;
                    $numErr++;
                } else {
                    $gender = test_input($_POST["gender"]);
                    $_SESSION['gender'] = $gender;
                    
                }
                if (empty($_POST["faculty"])) {
                    $facultyErr = "Hãy chọn phân khoa." ;
                    $numErr++;   
                } else {
                    $faculty = test_input($_POST["faculty"]);
                    $_SESSION['faculty'] = $faculty;
                }
                if (empty($_POST["birthday"])) {
                    $birthdayErr = "Hãy nhập ngày sinh." ;
                    $numErr++;
                } else {
                    $birthday = test_input($_POST["birthday"]);
                    if (!validateBirthday($_POST["birthday"])) {
                        $birthdayErr = "Hãy nhập ngày sinh đúng định dạng";
                        $numErr++;
                    }
                    $_SESSION['birthday'] = $birthday;

                }
                if (empty($_POST["address"])) {
                    $_SESSION['address'] = '';
                }else {
                    $address = test_input($_POST["address"]);
                    $_SESSION['address'] = $address;
                } 
                if (isset($_FILES['file'])) {
                    $file = $_FILES['file']['name'];
                    $fileTmpName = $_FILES['file']['tmp_name'];
                    $uploadOk = 0;
                    $date = date("YmdHis");
                    $fileName = pathinfo($file, PATHINFO_FILENAME);
                    $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
                    // Check file formats
                    if($imageFileType == 'jpg' || $imageFileType == 'png' || $imageFileType == 'jpeg' || $imageFileType == 'gif' || $imageFileType == '') {
                        $uploadOk = 1;
                    }
                    if ($uploadOk == 0) {
                        $imageErr = 'Chỉ được phép chọn file ảnh.';
                        $numErr++;
                    } else {
                        if (!file_exists('uploads/')) {
                            mkdir('uploads/', 0777, true);
                        }
                        $target_file = 'uploads/' . $fileName . '_' . $date . '.' . $imageFileType;
                        move_uploaded_file($fileTmpName, $target_file);
                        $_SESSION['avatar'] = $target_file;
                    }
                }    
                if ($numErr == 0) {
                    header("Location: verify.php");
                        
                }
            }
            function validateBirthday($birthday){
                $birthdays  = explode('/', $birthday);
                if (count($birthdays) == 3) {
                    return checkdate($birthdays[1], $birthdays[0], $birthdays[2]);
                }
                return false;
            }
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container">
                <div class="container__content">
                    <div class="error">
                        <?php 
                            if (!empty($nameErr)) {
                                echo $nameErr ."<br />";
                            }
                            if (!empty($genderErr)) {
                                echo $genderErr ."<br />";
                            }
                            if (!empty($facultyErr)) {
                                echo $facultyErr ."<br />";
                            }
                            if (!empty($birthdayErr)) {
                                echo $birthdayErr ."<br />";
                            }
                            if (!empty($imageErr)) {
                                echo $imageErr ."<br />";
                            }
                        ?>
                    </div>
                    <div class="form__item">
                        <label for="name" class="form__label">
                            Họ và tên
                            <span>*</span>
                        </label>
                        <input type="text" class="form__input" id="name" name="name">
                    </div>
                    <div class="form__item">
                        <div class="form__label">
                            Giới tính
                            <span>*</span>
                        </div>
                        <?php
                        foreach($genders as $gender => $value) {
                            echo    "<label class='form__gender'>
                                        $value
                                        <input type='radio' value= $gender name='gender' class='form__input input__gender'>
                                        <span class='checkmark'></span>
                                    </label>";
                        }
                        ?>
                    </div>
                    <div class="form__item">
                        <label for="faculty" class="form__label">
                            Phân khoa
                            <span>*</span>
                        </label>
                        <div class="faculty">
                            <select name="faculty" id="faculty" class="form__input form__faculty">
                                <!-- foreach loop -->
                                <?php
                                echo "<option value=''></option>";
                                foreach($faculties as $faculty => $value) {
                                    echo "<option value='$faculty'>$value</option>";
                                }
                                ?>
                            </select>
                            <span class="focus"></span>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="birthday" class="form__label">
                            Ngày sinh
                            <span>*</span>
                        </label>
                        <div class="form__birthday">
                            <div class="input-group">
                                <input class="form__input" id="birthday" name="birthday" placeholder="dd/mm/yyyy" type="text"/>
                            </div>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="address" class="form__label">
                            Địa chỉ
                        </label>
                        <input type="text" class="form__input" id="address" name="address">
                    </div>
                    <div class="form__item">
                        <label for="file" class="form__label">
                            Hình ảnh
                        </label>
                        <input type="file" id="file" name="file" class="fomr__input form__file" accept="image/*">
                    </div>
                                    
                    <input type="submit" name="submit" value="Đăng ký" class="form__submit">
    
                </div>
            </div>
        </form>
        
        <script>
            $(document).ready(function(){
                var date_input=$('input[name="birthday"]');
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'dd/mm/yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>
    </body>
</html>
