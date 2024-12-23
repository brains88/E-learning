@include('layout.header')

<style>
    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .profile-dashboard {
        padding: 20px;
        margin-left: 290px; /* Adjust this value based on the sidebar width */
        font-family: 'Inter', sans-serif;
        color: #2C2B5E;
        background-color: #f4f7fc;
        width: calc(100% - 260px); /* Dynamically adjust width based on the sidebar */
        max-width: 900px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 28px;
        margin: 0;
        color: #2C2B5E;
    }

    .header p {
        font-size: 16px;
        color: #6c757d;
        margin-top: 5px;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-photo {
        margin-bottom: 20px;
    }

    .profile-photo img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #2C2B5E;
    }

    .profile-info h2 {
        font-size: 24px;
        margin: 0;
        margin-top: 10px;
    }

    .profile-info p {
        font-size: 14px;
        color: #6c757d;
    }

    .profile-form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .form-group input {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .update-btn {
        background-color: #2C2B5E;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
        width: 100%;
        text-align: center;
    }

    .update-btn:hover {
        background-color: #44429d;
    }

    @media (max-width: 768px) {
        .profile-dashboard {
            margin-left: 0; /* Remove left margin for mobile view */
            width: 100%; /* Take full width */
            padding: 15px;
        }

        .form-group {
            flex: 1 1 100%;
        }

        .update-btn {
            padding: 12px;
        }
    }
</style>


<body>
@include('layout.adminnavbar') <!-- Sidebar included -->

<div class="profile-dashboard">
    <div class="header">
        <h1>My Profile</h1>
        <p>Manage your personal information and account settings.</p>
    </div>

    <!-- Display Success or Error Messages -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="profile-card">
        <div class="profile-photo">
            <img src="{{ $userData->image ? asset('storage/profile_images/' . $userData->image) : 'https://via.placeholder.com/120' }}" alt="Profile Picture">
        </div>
        <div class="profile-info">
            <h2>{{$userData->name}}</h2>
            <p>{{$userData->email}}</p>
        </div>
    </div>

    <div class="profile-card">
    <form class="profile-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $userData->name) }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $userData->email) }}">
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" value="{{ old('country', $userData->country) }}">
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>

            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" id="image" name="image">
            </div>

            <div style="flex: 1 1 100%;">
                <button type="submit" class="update-btn">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@include('layout.userfooter')
</body>
