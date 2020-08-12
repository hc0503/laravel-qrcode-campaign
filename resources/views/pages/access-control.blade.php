@extends('layouts/contentLayoutMaster')

@section('title', 'Access Control ')

{{-- page main content --}}
@section('content')
<div class="card">
  <div class="card-header">
    <h6 class="card-title">
      Your current role is @if(Auth::user()) @role('Admin') {{"Admin"}} @endrole @role('Editor') {{'Editor'}} 
      @endrole @else{{"Guest"}}
      @endif.
    </h6>
  </div>
  <div class="card-body">
    <div class="card-content">
      <form action="#">
        {{-- roles --}}
        <div class="roles">
          <a href="access-control/admin" class="btn btn-primary mr-2">Admin</a>
          <a href="access-control/editor" class="btn btn-secondary">Editor</a>
        </div>
        {{-- buttons --}}
        <div class="rolesContent pt-1 pb-1">
          <h6 class="mb-1 card-title">Buttons</h6>
          <button class="btn btn-info mr-2">Editor And Admin </button>
          @role('Admin')
          <button class="btn btn-primary">Only Admin</button>
          @endrole
        </div>
        <div class="collapsible-content">
          <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
            <div class="collapse-icon accordion-icon-rotate">
              <h4 class="card-title">Accordion</h4>
              <div class="accordion-default collapse-bordered">
                <div class="card collapse-header">
                  <div id="heading1" class="card-header collapse-header" data-toggle="collapse" role="button"
                    data-target="#accordion1" aria-expanded="false" aria-controls="accordion1">
                    <span class="lead collapse-title">
                      Article 1
                    </span>
                  </div>
                  <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1"
                    class="collapse">
                    <div class="card-content">
                      <div class="card-body">
                        Cheesecake cotton candy bonbon muffin cupcake tiramisu croissant. Tootsie roll sweet candy
                        bear
                        claw chupa chups lollipop toffee. Macaroon donut liquorice powder candy carrot cake macaroon
                        fruitcake. Cookie toffee lollipop cotton candy ice cream dragée soufflé.

                        Cake tiramisu lollipop wafer pie soufflé dessert tart. Biscuit ice cream pie apple pie
                        topping
                        oat cake dessert. Soufflé icing caramels. Chocolate cake icing ice cream macaroon pie
                        cheesecake
                        liquorice apple pie.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card collapse-header">
                  <div id="heading2" class="card-header collapse-header" data-toggle="collapse" role="button"
                    data-target="#accordion2" aria-expanded="false" aria-controls="accordion2">
                    <span class="lead collapse-title">
                      Article 2
                    </span>
                  </div>
                  <div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2"
                    class="collapse" aria-expanded="false">
                    <div class="card-content">
                      <div class="card-body">
                        Pie pudding candy. Oat cake jelly beans bear claw lollipop. Ice cream candy canes tootsie
                        roll
                        muffin powder donut powder. Topping candy canes chocolate bar lemon drops candy canes.

                        Halvah muffin marzipan powder sugar plum donut donut cotton candy biscuit. Wafer jujubes
                        apple
                        pie sweet lemon drops jelly cupcake. Caramels dessert halvah marshmallow. Candy topping
                        cotton
                        candy oat cake croissant halvah gummi bears toffee powder.
                      </div>
                    </div>
                  </div>
                </div>
                @role('Admin')
                <div class="card collapse-header">
                  <div id="heading3" class="card-header collapse-header" data-toggle="collapse" role="button"
                    data-target="#accordion3" aria-expanded="false" aria-controls="accordion3">
                    <span class="lead collapse-title">
                      Article 3 Only Admin
                    </span>
                  </div>
                  <div id="accordion3" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading3"
                    class="collapse" aria-expanded="false">
                    <div class="card-content">
                      <div class="card-body">
                        Gingerbread liquorice liquorice cake muffin lollipop powder chocolate cake. Gummi bears
                        lemon
                        drops toffee liquorice pastry cake caramels chocolate bar brownie. Sweet biscuit chupa chups
                        sweet.

                        Halvah fruitcake gingerbread croissant dessert cupcake. Chupa chups chocolate bar donut
                        tart.
                        Donut cake dessert cookie. Ice cream tootsie roll powder chupa chups pastry cupcake soufflé.
                      </div>
                    </div>
                  </div>
                </div>
                @endrole
                <div class="card collapse-header">
                  <div id="heading4" class="card-header" data-toggle="collapse" role="button" data-target="#accordion4"
                    aria-expanded="false" aria-controls="accordion4">
                    <span class="lead collapse-title">
                      Article 4
                    </span>
                  </div>
                  <div id="accordion4" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading4"
                    class="collapse" aria-expanded="false">
                    <div class="card-content">
                      <div class="card-body">
                        Icing sweet roll cotton candy brownie candy canes candy canes. Pie jelly dragée pie. Ice
                        cream
                        jujubes wafer. Wafer croissant carrot cake wafer gummies gummies chupa chups halvah bonbon.

                        Gummi bears cotton candy jelly-o halvah. Macaroon apple pie dragée bonbon marzipan
                        cheesecake.
                        Jelly jelly beans marshmallow.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="protected-route mt-2">
          <h6 class="card-title">Route Protection</h6>
          <p>
            You can add <strong>route protection</strong> using Laravel ACL. Only admin can visit eCommerce Dashboard.
          </p>
          <a href="{{url('modern-admin')}}"
            class="btn mt-1 @cannot('approve-post') {{'btn-danger'}} @else {{'btn-primary'}} @endcannot">Visit</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection