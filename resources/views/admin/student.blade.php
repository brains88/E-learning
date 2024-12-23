@include('layout.header')
<style>
/* General Styles */
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    overflow-x: hidden; /* Prevent horizontal scroll */
}

/* Sidebar adjustment */
.container {
    margin-left: 250px; /* Adjust based on the sidebar width */
    padding: 20px;
    transition: all 0.3s ease-in-out;
    max-width: calc(100% - 250px); /* Prevent container overflow */
}

.header {
    background-color: #2C2B5E;
    color: #fff;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 250px; /* Adjust based on sidebar width */
    transition: all 0.3s ease-in-out;
    max-width: calc(100% - 250px); /* Prevent header overflow */
}

.header h1 {
    font-size: 24px;
    margin: 0;
}

.profile {
    font-size: 16px;
}

/* Table Styles */
.table-container {
    overflow-x: auto; /* Enable scrolling for wider tables on small screens */
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background: #fff;
    padding: 15px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    background-color: #2C2B5E;
    color: #fff;
}

.table tbody td {
    vertical-align: middle;
    padding: 8px 12px;
    word-wrap: break-word;
}

.table tbody tr {
    border-bottom: 1px solid #ddd;
}

.table tbody tr:last-child {
    border-bottom: none;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .header {
        margin-left: 0;
        max-width: 100%;
    }

    .container {
        margin-left: 0;
        max-width: 100%;
    }

    .table-container {
        overflow: visible; /* No scrollbars */
    }

    .table {
        display: block;
    }

    .table thead {
        display: none; /* Hide headers on small screens */
    }

    .table tbody tr {
        display: block;
        margin-bottom: 10px;
        border-bottom: 2px solid #ddd;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 10px 5px;
        border-bottom: 1px solid #eee;
    }

    .table tbody td:last-child {
        border-bottom: none;
    }

    .table tbody td::before {
        content: attr(data-label); /* Add labels for each cell */
        font-weight: bold;
        flex-basis: 50%;
    }

    /* Buttons Styling */
    .table .btn {
        width: 100%; /* Full-width buttons on mobile */
        margin-bottom: 5px;
    }

    .table .btn:last-child {
        margin-bottom: 0;
    }
}
</style>

<body>
@include('layout.adminnavbar')

<div class="header">
    <h1>Registered Student</h1>
    <div class="profile">
        <span>Admin</span>
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Registered Students</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td data-label="#"> {{ $loop->iteration }} </td>
                        <td data-label="Name"> {{ $student->name }} </td>
                        <td data-label="Email"> {{ $student->email }} </td>
                        <td data-label="Role"> {{ ucfirst($student->role) }} </td>
                        <td data-label="Actions">
                            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('layout.userfooter')
