<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-lg-4 bg-dark text-light d-flex justify-content-start pt-2">
            <span id="hours">00</span>
            <span>:</span>
            <span id="minutes">00</span>
            <span>:</span>
            <span id="seconds">00</span>

        </div>

        <div class="col-md-8 col-sm-8 col-lg-8 bg-dark text-light d-flex justify-content-end p-1">
            LOGGED IN: <?php echo $emp_name; ?>
            <a href="logout.php" class='logout p-1 '>LOGOUT</a>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-center pt-1 pb-1">
            <input type="text" value="<?php echo date('Y-d-m');?>" class="p-2 w-30 fs-5 text-center" readonly>

        </div>
    </div>

    <div class="row">
        <h3 class='text-center title bg-success pt-2 pb-2 text-white'> TRANSPORT VEHICLE ATTENDANCE SYSTEM
        </h3>
    </div>
</div>

</div>