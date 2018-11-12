
    @if (session('message-success'))
        <div class="alert alert-success m-0" role="alert">
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">                         
                <span aria-hidden="true">×</span>
            </button>
            {{ session('message-success') }}
        </div>
    @endif

    @if (session('message-error'))
        <div class="alert alert-danger m-0" role="alert">
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">                         
                <span aria-hidden="true">×</span>
            </button>
            {{ session('message-error') }}
        </div>
    @endif

    @if (session('message-warning'))
        <div class="alert alert-warning m-0">
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">                         
                <span aria-hidden="true">×</span>
            </button>
            {{ session('message-warning') }}
        </div>
    @endif

