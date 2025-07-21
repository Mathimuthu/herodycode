<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Influencer Campaign | Dashboard</title>
  <link rel="shortcut icon" href="{{asset('assets/main/images/Viti.png')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .custom-navbar {
      background-color: #fff;
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }

    .navbar-logo {
      height: 50px;
    }

    .navbar-menu a {
      color: #333;
      font-weight: 500;
      text-decoration: none;
      margin: 0 15px;
      transition: color 0.2s ease;
    }

    .navbar-menu a:hover {
      color: #0d6efd;
    }

    .table thead th {
      vertical-align: middle;
    }

    .table tbody tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="container-fluid custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        <img src="{{asset('assets/digital/assets/img/logo.png')}}" alt="Herody Logo" class="navbar-logo">
      </div>
      <div class="navbar-menu d-flex align-items-center">
        <a href="{{ route('employer.dashboard') }}">Employer Home</a>
        <a href="{{route('admin.job.all')}}">Internships</a>
        <a href="{{route('employer.campaign.manage')}}">Employer Gigs Dashboard</a>
        <a href="{{route('admin.missions')}}">Projects</a>
        <a href="{{route('employer.logout')}}">Logout</a>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-primary">Influencer Data - {{ $campaign->title }}</h3>
      <a href="{{ route('employer.influencercampaign.statushistory', $campaign->id) }}" class="btn btn-outline-secondary">
        ← Back to Status History
      </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($influencers->isEmpty())
      <div class="alert alert-info">No influencer data found for this campaign.</div>
    @else
    <form action="{{ route('employer.influencercampaign.bulkUpdateStatus') }}" method="POST">
      @csrf
      <div class="card shadow-sm p-4">
        <div class="mb-3 d-flex gap-2 flex-wrap align-items-center">
          <select name="bulkstatus" class="form-select form-select-sm w-auto" required>
            <option value="">-- Select Status --</option>
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
            <option value="rejected">Rejected</option>
          </select>
          <button type="submit" class="btn btn-sm btn-success">✅ Bulk Update</button>
        </div>
    </form>

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-sm align-middle">
            <thead class="table-light text-center">
              <tr>
                <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <th>Link</th>
                <th>Followers</th>
                <th>Platform</th>
                <th>Engagement</th>
                <th>Type</th>
                <th>City</th>
                <th>Gender</th>
                <th>Past Work</th>
                <th>Created</th>
                <th>Status</th>
                <th>Content Status</th>
                <th>Uploaded File</th>
              </tr>
            </thead>
            <tbody>
              @foreach($influencers as $influencer)
              <tr class="text-center">
                <td>
                  <input type="checkbox" name="influencer_ids[]" value="{{ $influencer->id }}" class="form-check-input influencer-checkbox">
                </td>
                <td><a href="{{ $influencer->link }}" target="_blank" class="text-decoration-none">{{ $influencer->link }}</a></td>
                <td>{{ number_format($influencer->follower) }}</td>
                <td>{{ ucfirst($influencer->platform) }}</td>
                <td>{{ $influencer->engagement }}%</td>
                <td>{{ $influencer->collaboration_type }}</td>
                <td>{{ $influencer->city ?? '-' }}</td>
                <td>{{ ucfirst($influencer->gender) }}</td>
                <td>{{ $influencer->past_work ?? '-' }}</td>
                <td>{{ $influencer->created_at->format('d M Y') }}</td>
                <td>
                  <form action="{{ route('employer.influencercampaign.updateStatus', $influencer->id) }}" method="POST" class="d-flex flex-column gap-1">
                    @csrf
                    <select name="status" class="form-select form-select-sm" required>
                      <option value="pending" {{ $influencer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                      <option value="accepted" {{ $influencer->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                      <option value="rejected" {{ $influencer->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                  </form>
                </td>
                <td>{{ $influencer->content_status ?? '_' }}</td>
                <td>
                    @if($influencer->upload_file)
                        @php
                            $filePath = asset($influencer->upload_file);
                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'avif']))
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-success btn-sm w-100">
                                🖼️ View Image
                            </a>
                        @elseif(strtolower($extension) === 'pdf')
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-danger btn-sm w-100">
                                📄 View PDF
                            </a>
                        @elseif(in_array(strtolower($extension), ['mp4', 'mov']))
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-info btn-sm w-100">
                                🎬 View Video
                            </a>
                         @elseif(in_array($extension, ['doc', 'docx']))
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                📝 View DOCX
                            </a>
                        @else
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                                📁 View File
                            </a>
                        @endif
                         <form action="{{ route('employer.influencercampaign.UploadLiveStatus', $influencer->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm w-100 {{ $influencer->upload_file_status === 'live' ? 'btn-success' : 'btn-secondary' }}">
                                {{ $influencer->upload_file_status === 'live' ? 'Live' : 'Not Live' }}
                            </button>
                        </form>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const selectAll = document.getElementById('selectAll');
      const checkboxes = document.querySelectorAll('.influencer-checkbox');

      selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
      });
    });
  </script>

</body>
<!-- Footer -->
<footer class="footer bg-dark text-light py-4 mt-auto">
  <div class="container text-center">
    <small>© 2020 Jaketa Media & Entertainment Private Limited All rights reserved.</small>
  </div>
</footer>

</html>
