
 <!-- Modal -->
<div class="modal fade" id="@yield('modal_id','modal_id' )" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            @yield('form')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>    
                    <h5 class="modal-title">@yield('modal_title', 'modal' ) </h5>
                </div>
                <div class="modal-body">
                    <!--  -->
                    @yield('modal_body')
                    <!--  -->
                </div>
                @yield('modal_footer')
            </form>
        </div>
    </div>
</div>
<!--  -->