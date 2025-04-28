<x-app-layout>
    <div class="m-5 dashboard-section-container">
        <div class="feature-card">
        <a href="{{ route('pets.add_pets') }}">
          <h5>Add Pets</h5>
        </a>
          <p>Maintain the pet database by adding new animals, updating profiles, or removing inactive listings.</p>
          <ul class="sidebar-menu" id="sidebar-menu">
            <li> Add or edit pet profiles</li>
            <li>Update photos and medical info</li>
            <li>Track foster/adoption status</li>
          </ul>
        </div>

        <div class="feature-card">
          <h5>Adoption & Foster Applications</h5>
          <p>Quickly review incoming adoption and foster applications. Sort by urgency or applicant background.</p>
          <ul>
            <li>View applicant details</li>
            <li>Assign reviewers</li>
            <li>Auto-send email notifications</li>
          </ul>
        </div>

        <div class="feature-card">
          <h5>Users</h5>
          <p>Oversee user accounts including adopters, pet owners, and shelter partners.</p>
          <ul>
            <li>Ban/report suspicious users</li>
            <li>Grant admin/mod access</li>
            <li>Analyze user trends</li>
          </ul>
        </div>

        <div class="feature-card">
          <h5>Message</h5>
          <p>Facilitate safe and moderated communication between shelters and adopters.</p>
          <ul>
            <li>Search message history</li>
            <li>Filter by user or date</li>
            <li>Flag for moderation</li>
          </ul>
        </div>

        <div class="feature-card">
          <h5>Donations</h5>
          <p>Track donation history, generate monthly reports, and highlight top donors.</p>
          <ul>
            <li>Monitor real-time donations</li>
            <li>Export reports to CSV</li>
            <li>Manage donor communications</li>
          </ul>
        </div>
      </div>
</x-app-layout>
