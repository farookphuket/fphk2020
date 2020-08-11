

<?php
    $pay_paypal = site_url("public/img/pay_by_paypal-1.png");
    $pay_true = site_url("public/img/TrueWallet996520237.jpg");
    $pay_SCB= site_url("public/img/promptpaySCB.jpg");
    $pay_KBank = site_url("public/img/promtpayKBank.jpg");
?>
<div class="page-header">
    <h1>Payment method</h1>
</div>
<section id="section-c" class="grid">
    <div class="content-wrap">
    <ul>
        <li>
            <div class="card">
                <h2>Pay via your Paypal</h2>
                <img src="<?php echo $pay_paypal;?>" class="responsive">
                <div class="card-content">
                    <p>
                        Pay by paypal is the most easy and secure online payment solution if you want to pay via paypal click on the button below.
                    </p>
                    <p>
                        จ่ายผ่าน Paypal นั้นง่ายและปลอดภัยเมื่อท่านชำระเงินออนไลน์ หากท่านต้องการชำระผ่าน Paypal ท่านสามารถคลิกที่ปุ่มข้างล่างได้เลย
                    </p>
                    <a class="btn-pay" href="https://www.paypal.me/farookphuket/" target="_blank">Pay via Paypal</a>
                </div>
            </div>
        </li>
        <li>
            <div class="card">
                <h2>Pay @7-eleven</h2>
                <img src="<?php echo $pay_true;?>" class="responsive">
                <div class="card-content">
                    <p>
                        pay @7-eleven is a very easy way</p>
                        <p>if you are now in Thailand just show the bar code to the staff and tell them what is your payment amount.
                    </p>
                    <p>
                        You may have to be charge for 15-20 THB. for the service.
                    </p>
                    <p>
                        จ่ายที่เซเว่นได้ง่ายๆ แค่โชว์บาร์โค้ดให้พนักงานทำการสแกนจากนั้นบอกจำนวนเงินที่ท่านต้องการชำระ ท่านจะต้องจ่ายค่าบริการ 15-20 บาท
                    </p>
                </div>
            </div>
        </li>
        <li>
            <div class="card">
                <h2>Transfer money to KBank</h2>
                <img src="<?php echo $pay_KBank;?>" class="responsive">
                <div class="card-content">
                    <p>
                        Transfer money to KBank by scan the QR Code 
                    </p>
                </div>
            </div>
        </li>
        <li>
            <div class="card">
                <h2>Transfer money to SCB</h2>
                <img src="<?php echo $pay_SCB;?>" class="responsive">
                <div class="card-content">
                    <p>
                        Transfer money to SCB Bank by scan the QR Code 
                    </p>
                </div>
            </div>
        </li>
    </ul>
    </div>
    
</section>