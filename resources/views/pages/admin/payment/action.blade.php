<div class="dropdown">
    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuAction" data-bs-toggle="dropdown"
        aria-expanded="false">
        Action
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuAction">
        @if ($status == 1)
            <li><a class="dropdown-item status-btn" data-id="{{ $id }}" href="#">Approve Payment</a>
            </li>
        @endif
        <li><a class="dropdown-item" href="{{ route('admin.payment.show', $id) }}">Payment Detail</a></li>

        <li><a class="dropdown-item delete-btn" data-id="{{ $id }}" href="#">Delete</a></li>
    </ul>
</div>
