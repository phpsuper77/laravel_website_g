<ul class="reset menu std_mb">
    <li>
        <a class="accordion_toggler nav_sub_toggler" href="#account-navigation"><h3>Account Navigation</h3></a>
        <div class="accordion_content" id="account-navigation">
            <ul class="nav_sub">
                <li {{ $page == 'profile' ? 'class="current"' : '' }}>
                <a href="{{ url('account/profile') }}">Profile</a></li>
                <li {{ $page == 'email' ? 'class="current"' : '' }}>
                <a href="{{ url('account/email-preference') }}">Email Preferences</a></li>
                <li {{ $page == 'password' ? 'class="current"' : '' }}>
                <a href="{{ url('account/change-password') }}">Change Password</a></li>
                <li {{ $page == 'themes' ? 'class="current"' : '' }}>
                <a href="{{ url('account/themes') }}">Saved Themes</a></li>
                <li {{ $page == 'activity' ? 'class="current"' : '' }}>
                <a href="{{ url('account/stream') }}">All Activity</a></li>
                <li {{ $page == 'adverts' ? 'class="current"' : '' }}>
                <a href="{{ url('adverts/dashboard') }}">Advertise</a></li>
            </ul>
        </div>
    </li>
</ul>
