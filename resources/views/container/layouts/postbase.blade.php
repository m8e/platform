        <div class="modal fade in" id="screen-modal-post" role="dialog" aria-labelledby="screen-modal-post">
            <div class="modal-dialog" role="document" id="screen-modal-type-post">
                <form class="modal-content" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="title-modal-post"></h4>
                    </div>
                    <div class="modal-body">
                        @foreach($builds as $views)
                            {!! $views or '' !!}
                        @endforeach
                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit-modal-post"
                                class="btn btn-primary">{{trans('platform::common.apply')}}</button>
                    </div>
                </form>
            </div>
        </div>



