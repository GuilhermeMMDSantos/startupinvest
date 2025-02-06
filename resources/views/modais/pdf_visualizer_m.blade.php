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

    #header_visualize {
        position: fixed;
    }

    #pdf-container {
        padding-top: 30px;
    }

    #options-visualizer{
        display: none;
    }

    #btn-feito {
        border-radius: 20px;
        display:none;
    }
</style>

<div class="modal fade" id="pdfModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
    aria-labelledby="pdfSignModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Assinar Contrato</h5>&nbsp;
                <div id="options-visualizer">
                    <button class="btn btn-primary" id="btn-feito">Feito</button>
                    <button class="btn btn-primary" id="btn-cancelar-sign">Cancelar</button>
                    <button class="btn btn-primary" id="btn-assinar">Assinar</button>
                </div>
                <button type="button" class="close-pdf-visualizer-m">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="modal-body" id="body-of-visualizer">
                <div id="header_visualize">
                </div>
                <div id="pdf-container"></div>
                <form id="point-to-insert-sign">
                    @csrf
                    <input type="hidden" name="path_doc" id="path_doc">
                    <input type="hidden" name="id_investor" id="id-investor">
                    <input type="hidden" name="page_sign" id="page-sign">
                    <input type="hidden" name="point_x" id="point_x">
                    <input type="hidden" name="point_y" id="point_y">
                    <input type="hidden" name="signature" id="signature">
                    <input type="hidden" name="render_scale" id="render-scale">
                </form>
                <button type="button" class="btn btn-info" id="scrollToTopBtn" style="display: none;"><i
                        class="fa fa-arrow-up"></i></button>
            </div>
        </div>
    </div>
</div>
