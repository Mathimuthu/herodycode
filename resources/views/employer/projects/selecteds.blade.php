@extends('layouts.app')
@section('title', config('app.name') . ' | Selected Resumes')
@section('content')

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $employer->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow-sm border border-light">
    <div class="px-4 py-4 border-bottom border-light">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="h4 font-weight-bold text-dark">Selected Resumes</h2>
            @if($jas->count() > 0)
                <div class="d-flex align-items-center">
                    <span class="badge badge-success badge-pill">
                        {{ $jas->count() }} Selected Candidates
                    </span>
                </div>
            @endif
        </div>

        @if($jas->count() == 0)
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="w-24 h-24 mx-auto mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-check-circle fa-3x text-muted"></i>
                </div>
                <h3 class="h5 font-weight-semibold text-dark mb-2">No Selected Candidates Yet</h3>
                <p class="text-muted mb-4">Start selecting candidates from your shortlisted resumes to see them here.</p>
                @if($id)
                    <a href="{{ route('employer.job.applications', $id) }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        View Applications
                    </a>
                @endif
            </div>
        @else
            <!-- Selected Candidates List -->
            <div class="list-group list-group-flush">
                @foreach($jas as $ja)
                    <?php $user = DB::table('users')->find($ja->uid); ?>
                    @if($user)
                        <div class="list-group-item border-light">
                            <div class="media">
                                <!-- Profile Photo -->
                                <img src="@if($user->profile_photo != NULL){{ asset('assets/user/images/user_profile/'.$user->profile_photo) }}@else{{ asset('assets/user/images/frontEnd/demo.png') }}@endif"
                                     alt="{{ $user->name }}"
                                     class="mr-3 rounded-circle border" width="64" height="64">

                                <!-- User Info -->
                                <div class="media-body">
                                    <div class="d-flex flex-column flex-md-row justify-content-between">
                                        <div class="mb-3 mb-md-0">
                                            <h5 class="mb-1">
                                                <a href="{{ route('applicant.view', $ja->uid) }}"
                                                   class="text-dark hover:text-primary">
                                                    {{ $user->name }}
                                                </a>
                                            </h5>
                                            @if($user->state)
                                                <p class="text-muted small mb-2">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ $user->state }}
                                                </p>
                                            @endif

                                            <!-- Status Indicators -->
                                            <div class="d-flex flex-wrap mb-2">
                                                @if($ja->status == 5)
                                                    <span class="badge badge-warning badge-pill mr-2 mb-2">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Certificate Issued
                                                    </span>
                                                @endif

                                                @if($ja->status == 6)
                                                    <span class="badge badge-success badge-pill mr-2 mb-2">
                                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                                        Payment Completed
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Action Buttons - Improved Layout -->
                                        <div class="d-flex flex-column">
                                            <div class="btn-group btn-group-sm mb-2">
                                                <!-- Certificate Action -->
                                                @if($ja->status == 5)
                                                    <span class="btn btn-warning">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Certificate Issued
                                                    </span>
                                                @else
                                                    <a href="{{ route('employer.job.issue_certificate', [$ja->jid, $ja->uid]) }}"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-certificate mr-1"></i>
                                                        Issue Certificate
                                                    </a>
                                                @endif

                                                <!-- Payment Action -->
                                                @if($ja->status == 6)
                                                    <span class="btn btn-success ml-2">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Paid
                                                    </span>
                                                @else
                                                    <button onclick="pay('{{ $ja->uid }}')"
                                                            class="btn btn-success ml-2">
                                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                                        Pay Now
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Secondary Actions -->
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('applicant.view', $ja->uid) }}"
                                                   target="_blank"
                                                   class="btn btn-outline-primary ml-2">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View Profile
                                                </a>
                                                <a href="{{ route('employer.job.proofs', [$ja->jid, $ja->uid]) }}"
                                                   target="_blank"
                                                   class="btn btn-outline-secondary ml-2">
                                                    <i class="fas fa-file-alt mr-1"></i>
                                                    View Proof
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if($jas->hasPages())
                <div class="mt-4 pt-3 border-top border-light">
                    {{ $jas->links() }}
                </div>
            @endif
        @endif

        <!-- Quick Actions -->
        @if($id)
            <div class="mt-4 p-3 bg-light rounded border border-light">
                <h5 class="small font-weight-bold text-primary mb-3">Quick Actions</h5>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('job.details', $id) }}"
                       class="btn btn-primary">
                        <i class="fas fa-info-circle mr-1"></i>
                        View Internship Details
                    </a>
                    <a href="{{ route('employer.job.applications', $id) }}"
                       class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Applications
                    </a>
                    <a href="{{ route('employer.job.exportsl', $id) }}"
                       class="btn btn-success ml-2">
                        <i class="fas fa-file-export mr-1"></i>
                        Export Selected
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Payment Modal -->
@if($id)
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Payment Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employer.job.payout', [$id]) }}" method="post" id="paymentForm">
                @csrf
                <input type="hidden" name="uid" id="paymuid">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="stipend">Amount to Pay</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₹</span>
                            </div>
                            <input type="number"
                                   name="stipend"
                                   id="stipend"
                                   class="form-control"
                                   placeholder="0.00"
                                   min="0"
                                   step="0.01"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-success">
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    function pay(uid) {
        $('#paymuid').val(uid);
        $('#payModal').modal('show');
    }

    // Add loading state to form submission
    $('#paymentForm').submit(function() {
        var submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);
        submitButton.html('<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Processing...');
    });
</script>
@endsection
