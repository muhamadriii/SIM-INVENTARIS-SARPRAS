<div class="dropdown">
    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuAction" data-bs-toggle="dropdown"
        aria-expanded="false">
        Action
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuAction">
        @if (Auth::user()->type == 'merchant')
            @if ($status == 3)
                <li><a class="dropdown-item status-btn" data-id="{{ $id }}" href="#">Finish Order</a>
                </li>
            @endif
        @endif
        @if (Auth::user()->type == 'merchant')
            @if ($status >= 2)
                <li><a class="dropdown-item resi-btn" href="#" data-id="{{ $id }}">Insert Resi</a>
                </li>
            @endif
            @if ($status == 1)
                <li><a class="dropdown-item status-btn" data-id="{{ $id }}" href="#">Approve
                        Payment</a>
                </li>
            @endif
            <li><a class="dropdown-item edit-btn" href="{{ route('admin.orders.edit', $id) }}">Edit</a></li>
        @endif
        <li><a class="dropdown-item" href="{{ route('admin.orders.show', $id) }}">Show</a></li>

        <li>
            <hr class="dropdown-divider">
        </li>
        @if (Auth::user()->type == 'merchant')
            <li><a class="dropdown-item delete-btn" data-id="{{ $id }}" href="#">Delete</a></li>
        @endif
    </ul>
</div>
