@extends('dashboard.layouts.default')

@section('mainContent')
<div class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
        <div class="header">
          <div class="header-body">
            <div class="row align-items-end">
              <div class="col">
                <h6 class="header-pretitle">New Activity</h6>
                <h1 class="header-title">创建活动</h1>
              </div>
            </div>
          </div>
        </div>

        <div id="section-content">
          <script type="text/javascript">
            function formSubmit(event) {
              document.querySelector('#input-content').value = document.querySelector('#quill-content').firstChild.innerHTML;
              // event.preventDefault();
            }
          </script>

          <form id="form-article" class="mb-4" action="{{ route('dashboard.activities.store') }}" method="POST"
                enctype="multipart/form-data"
                onsubmit="formSubmit(event)">
            {{ csrf_field() }}

            @include('activity::dashboard.activities._form')

            <button type="submit" class="btn w-100 btn-primary">创建</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
