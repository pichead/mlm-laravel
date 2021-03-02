@if(session('error'))
  <div id="user-error-msg" class="alert alert-success alert-dismissible fade show">
  {{ session('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  </div>
@endif

@if(session('failerror'))
  <div id="user-error-msg" class="alert alert-danger alert-dismissible fade show">
  {{ session('failerror') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  </div>
@endif


<div id="user-success-msg" class="alert alert-success alert-dismissible fade d-none">
  <span id="json-success-message"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div id="user-faild-msg" class="alert alert-danger alert-dismissible fade d-none">
  <span id="json-faild-message"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>