@extends('layouts.app')

@section('title', config('app.name').' | Campaign')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Campaign Descriptions</h1>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('employer.campaign-descriptions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Create New
                </a>
                
                <!-- Optional: Add search or filter controls here -->
            </div>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Task Name</th>
                                    <th>Description</th>
                                    <th class="d-none d-md-table-cell">Screenshot</th>
                                    <th class="d-none d-md-table-cell">YouTube</th>
                                    <th class="d-none d-sm-table-cell">Per Cost</th>
                                    <th class="text-center">Actions</th>
                                    <th class="d-none d-sm-table-cell">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($descriptions as $description)
                                    <tr>
                                        <td>{{ $description->task_name }}</td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $description->description }}">
                                                {{ Str::limit($description->description, 50) }}
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if ($description->sample_screenshot)
                                                <a href="{{ asset('assets/campaign_screenshots/' . basename($description->sample_screenshot)) }}" 
                                                   class="btn btn-sm btn-outline-secondary" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#screenshotModal{{ $description->id }}">
                                                    <i class="fas fa-image"></i> View
                                                </a>
                                                
                                                <!-- Screenshot Modal -->
                                                <div class="modal fade" id="screenshotModal{{ $description->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $description->task_name }} - Screenshot</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ asset('assets/campaign_screenshots/' . basename($description->sample_screenshot)) }}" 
                                                                     class="img-fluid" alt="Screenshot">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-light text-dark">None</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if ($description->youtube_link)
                                                <a href="{{ $description->youtube_link }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                    <i class="fab fa-youtube"></i> Watch
                                                </a>
                                            @else
                                                <span class="badge bg-light text-dark">None</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{ $description->gig_id ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('employer.campaign-descriptions.edit', $description->id) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline ms-1">Edit</span>
                                                </a>
                                                <a href="{{ route('employer.questions.create', ['campaign_id' => $description->id]) }}" class="btn btn-sm btn-success">Create Questions</a>
                                                <a href="{{ route('employer.questions.answers', ['campaign_id' => $description->id]) }}" class="btn btn-sm btn-success">View Answer</a>
                                                <form action="{{ route('employer.campaign-descriptions.destroy', $description->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="d-none d-sm-inline ms-1">Delete</span>
                                                    </button>
                                                </form>
                                                
                                                <!-- Mobile-only dropdown for additional options -->
                                                <div class="dropdown d-md-none">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        More
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($description->sample_screenshot)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ asset('assets/campaign_screenshots/' . basename($description->sample_screenshot)) }}" target="_blank">
                                                                    <i class="fas fa-image me-2"></i> View Screenshot
                                                                </a>
                                                            </li>
                                                        @endif
                                                        
                                                        @if ($description->youtube_link)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ $description->youtube_link }}" target="_blank">
                                                                    <i class="fab fa-youtube me-2"></i> YouTube Link
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                          <td class="text-center">
                                           <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                               <button class="btn btn-sm {{ $description->referral_status ? 'btn-success' : 'btn-secondary' }}"
                                                       onclick="toggleStatus({{ $description->id }}, this)">
                                                   <span class="d-none d-sm-inline">
                                                       {{ $description->referral_status ? 'Active' : 'Inactive' }}
                                                   </span>
                                               </button>
                                           </div>
                                        </td>

                                            <script>
                                                function toggleStatus(campaignId, btn) {
                                                    fetch(`/employer/campaign-description/toggle-status/${campaignId}`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        }
                                                    })
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error('Network response was not ok.');
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(data => {
                                                        const span = btn.querySelector('span');
                                                        if (data.newStatus === 1) {
                                                            btn.classList.remove('btn-secondary');
                                                            btn.classList.add('btn-success');
                                                            span.textContent = 'Active';
                                                        } else {
                                                            btn.classList.remove('btn-success');
                                                            btn.classList.add('btn-secondary');
                                                            span.textContent = 'Inactive';
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error toggling status:', error);
                                                    });
                                                }
                                            </script>
                                            


                                                 
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">No campaign descriptions found</p>
                                                <a href="{{ route('employer.campaign-descriptions.create') }}" class="btn btn-sm btn-primary mt-3">
                                                    Create your first description
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Add pagination here if needed -->
            @if(isset($descriptions) && method_exists($descriptions, 'links'))
                <div class="mt-4">
                    {{ $descriptions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
