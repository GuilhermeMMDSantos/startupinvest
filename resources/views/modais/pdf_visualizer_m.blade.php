<style>
    .pdf-page {
        display: block;
        border: 1px solid #cccccc59;
        margin-bottom: 20px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    #scrollToTopBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        z-index: 1000;
    }

    #header_visualize{
        position: fixed;
    }

    #pdf-container{
        padding-top:30px;
    }

    #btn-feito{
        border-radius:20px;
    }

</style>

<div class="modal fade" id="pdfModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="pdfSignModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assinar Contrato</h5>&nbsp;
                <button class="btn btn-primary" id="btn-feito">Feito</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="header_visualize">
                    Page: <span id="page_num">0</span> / <span id="page_count">0</span>
                </div>
                <div id="pdf-container"></div>
                
                <button type="button" class="btn btn-info" id="scrollToTopBtn" style="display: none;"><i class="fa fa-arrow-up"></i></button>
            </div>
        </div>
    </div>
</div>