@extends('layouts.admin.app')
@section('content')
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="text-align: center">
                            <div class="tf-tree example">
                                <ul>
                                    <li>
                                        <span class="tf-nc">{{ $member->name }}</span>
                                        <ul>
                                            @foreach ($member->childrens as $children)
                                                <li>
                                                    <a
                                                        href="{{ route('admin.member.diagram', ['member_id' => $children->id]) }}">
                                                        <span class="tf-nc">{{ $children->name }} <br />
                                                            {{ data_get($children, 'level_user.level') }} <br />
                                                            {{ $children->descendants->count() }} Member
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        @foreach ($levels as $key => $level)
                                            @if ($key == 6)
                                            @break
                                        @endif
                                        <th scope="col-12">
                                            <a
                                                href="{{ route('admin.member.diagram', ['member_id' => $member->id, 'level' => $level->level]) }}">
                                                <span class="badge bg-primary mr-2" style="width: 100px;">
                                                    Level {{ $level->level }}</span>
                                            </a>
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($levels as $key => $level)
                                        @if ($key > 5)
                                            @if ($key == 12)
                                            @break
                                        @endif
                                        <th scope="col-12">
                                            <a
                                                href="{{ route('admin.member.diagram', ['member_id' => $member->id, 'level' => $level->level]) }}">
                                                <span class="badge bg-primary mr-2" style="width: 100px;">
                                                    Level {{ $level->level }}</span>
                                            </a>
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($levels as $key => $level)
                                    @if ($key > 11)
                                        <th scope="col-12">
                                            <a
                                                href="{{ route('admin.member.diagram', ['member_id' => $member->id, 'level' => $level->level]) }}">
                                                <span class="badge bg-primary mr-2" style="width: 100px;">
                                                    Level {{ $level->level }}</span>
                                            </a>
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($members->count() > 0)
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <table class="table table-responsive">
                            <tr>
                                <th>No</th>
                                <th>Level</th>
                                <th>Member</th>
                                <th>ID</th>
                                <th>Tanggal Register</th>
                                <th>Lama Register</th>
                                <th>Upline</th>
                                <th>ID Upline</th>
                            </tr>

                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ data_get($member, 'level_user.level') }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->code }}</td>
                                    <td>{{ $member->created_at->format('d M Y') }}</td>
                                    <td>{{ $member->created_at->diffForHumans() }}</td>
                                    <td>{{ data_get($member, 'parent_data.name') }}</td>
                                    <td>{{ data_get($member, 'parent_data.code') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('style')
    <style type="text/css">
        .table {
            border-radius: 5px;
            width: 50%;
            margin: 0px auto;
            float: none;
            color: red;
        }

        .tree,
        .tree ul,
        .tree li {
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .tree {
            margin: 0 0 1em;
            text-align: center;
        }

        .tree,
        .tree ul {
            display: table;
        }

        .tree ul {
            width: 100%;
        }

        .tree li {
            display: table-cell;
            padding: .5em 0;
            vertical-align: top;
        }

        .tree li:before {
            outline: solid 1px #666;
            content: "";
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
        }

        .tree li:first-child:before {
            left: 50%;
        }

        .tree li:last-child:before {
            right: 50%;
        }

        .tree code,
        .tree span {
            border: solid .1em #666;
            border-radius: .2em;
            display: inline-block;
            margin: 0 .2em .5em;
            padding: .2em .5em;
            position: relative;
        }

        .tree ul:before,
        .tree code:before,
        .tree span:before {
            outline: solid 1px #666;
            content: "";
            height: .5em;
            left: 50%;
            position: absolute;
        }

        .tree ul:before {
            top: -.5em;
        }

        .tree code:before,
        .tree span:before {
            top: -.55em;
        }

        .tree>li {
            margin-top: 0;
        }

        .tree>li:before,
        .tree>li:after,
        .tree>li>code:before,
        .tree>li>span:before {
            outline: none;
        }

        .bg-warning:hover {
            background-color: #a87408 !important;
        }

        .badge {
            border-style: solid;
            border-color: black;
            color: white;
            border-radius: 5px;
            border-width: thin;
        }
    </style>

    <link href="https://unpkg.com/treeflex/dist/css/treeflex.css" rel="stylesheet">
@endpush
