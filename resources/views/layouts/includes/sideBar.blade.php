<nav class="active" id="sideBar">
    <ul class="list-unstyled lead">
        <li>
            <a href=""><i class="fa fa-home fa-lg"></i>Home</a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}">
                <i class="fa fa-box fa-lg"></i>Orders
            </a>
        </li>
        <li>
            <a href="{{ route('transcations.index') }}">
                <i class="fa fa-money-bill fa-lg"></i>Transactions
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">
                <i class="fa fa-truck fa-lg"></i>Product
            </a>
        </li>
    </ul>
</nav>
