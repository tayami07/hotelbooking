<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thyzen - Contact</title>

    <!-- Links -->
    <?php require('inc/links.php');
    ?>

</head>

<body>
    <?php
        $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
        
    ?>

    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Contact Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Esse assumenda consequatur suscipit aut distinctio nihil ea incidunt ullam,
            recusandae est sed molestiae odit mollitia quo porro rerum provident eligendi labore!
        </p>
    </div>

    <!-- Conatact Details -->
    <div class="container border border-black">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_r['iframe'] ?>"></iframe>

                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
                    </a>

                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>
                    <?php
                    if ($contact_r['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i>+$contact_r[pn2]
                            </a>
                        data;
                    }
                    ?>


                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: <?php echo $contact_r['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?>
                    </a>

                    <div class="col-lg-4 mt-4">
                        <h5 class="mb-3">Follow us</h5>
                        <?php
                        if ($contact_r['tw'] != '') {
                            echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block text-dark fs-5 me2">
                                <i class="bi bi-twitter me-1"></i>
                            </a>
                            data;
                        }
                        ?>
                        
                        <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark fs-5 me2">
                            <i class="bi bi-facebook me-1"></i>
                        </a>
                        <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark fs-5">
                            <i class="bi bi-instagram me-1"></i>
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form method="POST">
                        <h5>Send a message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Name</label>
                            <input name="name" type="text" class="form-control shadow-none" required>
                        </div>

                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input name="email" type="email" class="form-control shadow-none" required>
                        </div>

                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input name="subject" type="text" class="form-control shadow-none" required>
                        </div>

                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea name="message" class="form-control" rows="5" style="resize:none;"></textarea>
                        </div>

                        <button type="submit" name="send" class="btn btn-primary text-white custom-bg mt-3">Send</button>
                        <!-- <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a> -->

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['send']))
        {
            $frm_data = filteration($_POST);

            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

            $res = insert($q, $values, 'ssss');
            if($res==1){
                alert('success', 'Mail sent.');
            }
            else{
                alert('error', 'Server down. Please try again later.');
            }
        }
    ?>

    <?php require('inc/footer.php'); ?>

</body>

</html>