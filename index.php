<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo-with-text_2.png">

    <title>PDF Series Generator</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/logo-with-text_2.png" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-bootstrap-wizard.css" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('images/BG-2.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            box-sizing: border-box;
        }

        .header-bg {
            background-color: #001B69;
            color: #fff;
            padding: 5px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .section-title {
            padding: 5px 0px 05px 10px;
            background-color: #15253F;
            border-radius: 2px;
            color: #fff;
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 10px;
        }

        .note-bg {
            background-color: #15253F;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .total-bg {
            background-color: #001B69;
            color: #fff;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .table-bordered>tbody>tr>td {
            border: 1px solid #ddd;
        }

        .table>thead>tr>th {
            background-color: #15253F;
            color: #fff;
            border: 1px solid #A6A6A6;
        }

        .bordered-div {

            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .bordered-right {
            border-right: 1px solid #ddd;
            /* padding: 15px; */

        }

        .footer-note {
            margin-top: 30px;
            background-color: #f0f0f0;
        }

        .top_table {
            background-color: #f0f0f0;
        }

        #hidden_download {
            display: none;
        }

        .empty-row td {
            padding: 10px;
            /* Adjust the padding as needed */
            height: 40px;
            /* Optional: set a fixed height for empty rows if desired */
        }

        .disclaimer-section {
            margin-top: 20px;
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .disclaimer-bg {
            background-color: #C9082A;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>


<body>
    <div style="overflow-y:auto">
        <!--   Creative Tim Branding   -->
		<?php
        if (!isset($_SESSION["loggedIn"])) {
            $link = 'login';
        } else {
            $link = 'dashboard';
        }

        ?>
        <a href="<?php echo $link; ?>">
            <div class="logo-container">
                <div class="logo">
                    <img src="assets/img/logo-with-text_2.png">
                </div>
                <!-- <div class="brand">
                   PDF Genrator
                </div> -->
            </div>
        </a>
        <!--   Big container   -->
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <!--      Wizard container        -->
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="blue" id="wizard">
                            <form id="pdfForm" action="generate_pdf.php" method="post" enctype="multipart/form-data">
                                <div class="wizard-header">
                                    <h3 class="wizard-title">
                                        PDF Series Generator
                                    </h3>
                                    <h5>Specify details for each series below and upload the PDF to generate a custom series.</h5>
                                </div>

                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#series_details" data-toggle="tab">Series Details</a></li>
                                        <li><a href="#upload_pdf" data-toggle="tab">Upload PDF</a></li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="series_details">
                                    <div class="row mr-3">
                                        <button type="button" class="btn btn-sm btn-info btn-fill pull-right" id="addRow">Add New Row</button>
                                    </div>
                                        <div id="seriesContainer">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"></span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" for="series_text[]">Series Text</label>
                                                            <input type="text" class="form-control" name="series_text[]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"></span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" for="start_number[]">Start Number</label>
                                                            <input type="number" class="form-control" name="start_number[]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"></span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" for="page_range[]">Page Range (e.g., 1-10)</label>
                                                            <input type="text" class="form-control" name="page_range[]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"></span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" for="text_color[]">Text Color</label>
                                                            <input type="color" class="form-control" name="text_color[]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"></span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" for="position[]">Position (X,Y) e.g., 20,30</label>
                                                            <input type="text" class="form-control" name="position[]" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-sm btn-danger btn-fill removeRow" style="display: none;">Remove Row</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="upload_pdf">
                                        <div class="col-sm-12 col-sm-offset-0">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    <!-- <label class="control-label" for="pdf_file"></label> -->
                                                    <img src="assets/img/upload.png" class="picture-src" id="wizardPicturePreview" title="" />
                                                    <input type="file" name="pdf_file" accept=".pdf" id="wizard-picture">
                                                </div>
                                                <h6>Upload PDF</h6>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon"></span>
                                                <div class="form-group label-floating">
                                                    
                                                    <input type="file">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="wizard-footer">
                                    <div class="pull-right">
                                        <input type='button' style="background-color: #00bcd4;" class='btn btn-next btn-fill btn-wd' name='next' value='Next' />
                                        <input type="submit" style="background-color: #00bcd4;" class="btn btn-finish btn-fill btn-danger btn-wd" name="generate_pdf" value="Generate PDF Series" />
                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                                    </div>
                                    <div class="pull-right">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>

                            <!-- Loader -->
                            <div class="loader-div">
                          <img id="loader" src="images/loader.gif" class="loader-img" style="display: none;" />
                            </div>
                        </div>
                    </div> <!-- wizard container -->
                </div>
            </div><!-- end row -->
        </div> <!--  big container -->

        <div class="footer">
            <div class="container text-center">
                Made with <i class="fa fa-heart heart"></i> by <a href="https://www.venturetronics.com/">Venturetronics</a>.
            </div>
        </div>
    </div>

</body>
<!--   Core JS Files   -->
<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js?clear_cache=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/libraries/sweetalert.min.js"></script>

<!--  Plugin for the Wizard -->
<script src="assets/js/material-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="assets/js/jquery.validate.min.js"></script>
<script>
    document.getElementById('addRow').addEventListener('click', function() {
        var container = document.getElementById('seriesContainer');
        var row = document.createElement('div');
        row.className = 'row';

        row.innerHTML = `
        <hr>
        <div class="col-sm-12">
                <button type="button" class="btn btn-sm btn-danger btn-fill removeRow pull-right">Remove Row</button>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <div class="form-group label-floating">
                        <label class="control-label" for="series_text[]">Series Text</label>
                        <input type="text" class="form-control" name="series_text[]" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <div class="form-group label-floating">
                        <label class="control-label" for="start_number[]">Start Number</label>
                        <input type="number" class="form-control" name="start_number[]" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <div class="form-group label-floating">
                        <label class="control-label" for="page_range[]">Page Range</label>
                        <input type="text" class="form-control" name="page_range[]" placeholder="e.g., 1-10" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <div class="form-group label-floating">
                        <label class="control-label" for="text_color[]">Text Color</label>
                        <input type="color" class="form-control" name="text_color[]" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <div class="form-group label-floating">
                        <label class="control-label" for="position[]">Position (X,Y)</label>
                        <input type="text" class="form-control" name="position[]" placeholder="e.g., 20,30" required>
                    </div>
                </div>
            </div>

            
        `;

        container.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('removeRow')) {
            e.target.closest('.row').remove();
        }
    });
    function showLoader() {
        $("#loader").show(); // Show loader
        $("input[name='generate_pdf']").prop("disabled", true); // Disable button
    }

    $(document).ready(function () {
        $("#pdfForm").submit(function () {
            showLoader(); // Ensure loader shows even if JS runs late
        });
    });
</script>

</html>