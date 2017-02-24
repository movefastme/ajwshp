<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>
    .borderless td, .borderless th {
        border: none;
    }
    body {
        background: url('http://wallpaper-gallery.net/images/pink-wallpaper/pink-wallpaper-12.gif') 100%;
        /* background-repeat: no-repeat; */
    }
    form{
        background-color: #FFF;
        border-radius: 25px;
        padding: 10px;
        margin-top: 20px;
    }
</style>

<?php
require_once ('Parking.php');

$parking = new Parking();
$res = $parking->get_detail_parking(isset($_GET['parking_id']) ? $_GET['parking_id'] : 0);

if (!$res) {
    echo "CAR NOT FOUND";
} else {
    ?>

    <div class="col-md-6 col-sm-offset-3">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">หมายเลขทะเบียนรถ</label>
                <div class="col-sm-9">
                    <?= $res['car_id'] ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">หมวดจังหวัด</label>
                <div class="col-sm-9">
                    <?= $res['province'] ?>
                </div>
            </div>
            <div class="formInput">
                <div class="form-group">
                    <label class="col-sm-3 control-label">วันเวลาที่เข้า</label>
                    <div class="col-sm-9">
                        <?= $res['check_in'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">วันเวลาที่ออก</label>
                    <div class="col-sm-9">
                        <?= $res['check_out'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">จำนวนชั่วโมงที่จอด</label>
                    <div class="col-sm-9">
                        <?= $res['hour'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">จำนวนเงินค่าจอด</label>
                    <div class="col-sm-9" id="price">
                        <?= $res['price'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">รับเงิน</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="pay" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button id="submit" type="submit" class="btn btn-default">คำนวณเงินทอน</button>
                    </div>
                </div>
            </div>
            <div id="result" style="display:none">
                <div class="form-group">
                    <label class="col-sm-3 control-label">จำนวนชั่วโมงที่จอด</label>
                    <div class="col-sm-9">
                        <?= $res['hour'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">จำนวนเงินที่รับ</label>
                    <div class="col-sm-9" id="inputPay">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">จำนวนเงินทอน</label>
                    <div class="col-sm-9" id="change">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 text-center">จำนวนเงินทอนที่ต้องการ</label>
                </div>
                <div class="form-group">
                    <div class="">500.00 บาท จำนวน <span id="bank500"></span> ฉบับ</div>
                </div>
                <div class="form-group">
                    <div class="">100.00 บาท จำนวน <span id="bank100"></span> ฉบับ</div>
                </div>
                <div class="form-group">
                    <div class="">50.00 บาท จำนวน <span id="bank50"></span> ฉบับ</div>
                </div>
                <div class="form-group">
                    <div class="">20.00 บาท จำนวน <span id="bank20"></span> ฉบับ</div>
                </div>
                <div class="form-group">
                    <div class="">10.00 บาท จำนวน <span id="bank10"></span> ฉบับ</div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#submit').click(function () {
            save();
            return false;
        });
        function save() {
            $('#inputPay').html($('input[name=pay]').val());
            $('#change').html(parseFloat($('input[name=pay]').val()) - parseFloat($('#price').html()));
            $.ajax({
                url: 'save_history.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    price: $('#price').html(),
                    pay: $('input[name=pay]').val(),
                    change: parseFloat($('input[name=pay]').val()) - parseFloat($('#price').html())
                },
                success: function () {
                    $('.formInput').hide();
                    $('.result').show();
                }
            });
        }

    });
</script>