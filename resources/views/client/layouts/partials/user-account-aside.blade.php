<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="javascript:void(0)"><i class="fa fa-user"></i> Your Info <i href="#collapse0" data-toggle="collapse" class="fa fa-chevron-up panel-minimise pull-right"></i></a>
            </h4>
        </div>
        <div id="collapse0" class="panel-collapse collapse in">
            <ul class="list-group">
                <li class="list-group-item">
                    {{auth()->user()->name}} <br>
                    {{auth()->user()->email}} <br>
                    {{auth()->user()->mobile}} <br>
                </li>
            </ul>
        </div>
        <div class="panel-footer text-center"><a href="{{URL::to('/account/profile')}}" class="btn btn-default btn-block"> <i class="fa fa-pencil"></i> Update</a></div>
    </div>
</div>


<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="javascript:void(0)">My Account <i href="#collapse1" data-toggle="collapse" class="fa fa-chevron-up panel-minimise pull-right"></i></a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse in">
            <ul class="list-group">
                <li class="list-group-item"><a href="{{URL::to('/account/profile')}}" class="@if(Request::is('account/profile')) active @endif">Edit Profile</a></li>
                <li class="list-group-item"><a href="{{URL::to('/account/password')}}" class="@if(Request::is('account/password')) active @endif">Change Password</a></li>
                {{--<li class="list-group-item"><a href="#">Address Book</a></li>--}}
            </ul>
        </div>
    </div>
</div>

<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="javascript:void(0)">My Order <i href="#collapse2" data-toggle="collapse" class="fa fa-chevron-up panel-minimise pull-right"></i></a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse in">
            <ul class="list-group">
                <li class="list-group-item"><a href="{{URL::to('/')}}" class="@if(Request::is('/')) active @endif">New Shopping/Order</a></li>
                <li class="list-group-item"><a href="{{URL::to('/cart-products')}}" class="@if(Request::is('cart-products')) active @endif"> Cart Product</a></li>
                <li class="list-group-item"><a href="{{URL::to('/wish-list-products')}}" class="@if(Request::is('wish-list-products')) active @endif">Wishlist Product</a></li>
                <li class="list-group-item"><a href="{{URL::to('/orders/history')}}" class="@if(Request::is('orders/history')) active @endif">Order History</a></li>
                {{--<li class="list-group-item"><a href="#">Wish List</a></li>--}}
            </ul>

        </div>
    </div>
</div>