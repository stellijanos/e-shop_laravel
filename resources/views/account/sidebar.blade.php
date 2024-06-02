<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <a href="{{url('account')}}" class="nav-link">My Account</a>
        </div>
        <div class="card-body">
            <a href="" class="nav-link">Favourites</a> 
            <a href="" class="nav-link">Orders</a> 
            <a href="" class="nav-link">Saved Addresses</a> 
            <a href="{{route('account.edit')}}" class="nav-link">Update Account Details</a> 
            <a href="" class="nav-link">Change password</a> 
            <a href="{{route('account.delete')}}" class="nav-link">Delete Account</a> 
            <form action="{{url('logout')}}" method="post">
                @csrf
                <button href="" class="nav-link">Logout</button>
            </form>
        </div>
    </div>
</div>
