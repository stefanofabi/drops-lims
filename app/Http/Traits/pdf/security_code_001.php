<style>
	td {
		width: 100mm;
	}
</style>

<style>

    .cover {
        background: #FFFFA6;
        margin-left: 20px;
    }


    .cover td {
        width: 150mm;
    }

    .info {
        margin-left: 50px
    }

    .info td {
        text-align: left;
        width: 100mm;
    }

    .title {
        font-weight: bold;
        font-size: 16px;
    }

    hr {
        border: 0.5px;
    }

</style>

<page backtop="40mm" backbottom="50mm">
    <page_header>

        <img width="100" height="100" src="<?php echo public_path() ?>/img/logo.png" style="float: left">

        <table class="cover">
            <tr>
                <td class="title"> Title 1 </td>
            </tr>
        </table>

        <br />

        <table class="cover">
            <tr>
                <td> Text 1 </td>
            </tr>

            <tr>
                <td> Text 2 </td>
            </tr>

            <tr>
                <td> Text 3 </td>
            </tr>
        </table>

        <p />

        <div style="margin-left: 5%">
            <?php echo Lang::get('patients.patient').": $patient_full_name"; ?> <br />
            <?php echo Lang::get('patients.unique_identifier').": $patient_id"; ?> <br />
            <br />
            <?php echo Lang::get('patients.expiration_notice', ['date' => date('d/m/Y', strtotime($expiration_date))]); ?> <br />
        </div>


        <div style="margin-left: 5%; margin-top: 1%; color: red;">
            <?php echo Lang::get('patients.notice_confidentiality') ?>
        </div>

        <div style="background-color: #DFDDDC; width: 500px; height: 40px;text-align: center; margin-left: 15%; margin-top: 2%; padding-top: 20px; font-size: 20px">
           <strong> <?php echo Lang::get('patients.security_code').": ".$security_code; ?> </strong>
        </div>
    </page_header>
</page>
