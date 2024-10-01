@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body ">

                    <h6 class="card-title  mb-4">
                        <div class="row">
                            <div class="col-sm-8 col-md-6">
                                @php echo $ticket->statusBadge; @endphp
                                [@lang('Ticket#'){{ $ticket->ticket }}] {{ $ticket->subject }}
                            </div>
                            <div class="col-sm-4  col-md-6 text-sm-end mt-sm-0 mt-3">
                                @if($ticket->status != 3)
                                <button class="btn btn--danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#DelModal">
                                    <i class="fa fa-lg fa-times-circle"></i> @lang('Close Ticket')
                                </button>
                                @endif
                            </div>
                        </div>
                    </h6>



                    <form action="{{ route('admin.ticket.reply', $ticket->id) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
                        @csrf


                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="message" rows="5" required id="inputMessage"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-12">
                                        <label for="inputAttachments">@lang('Attachments')</label> <span class="text--danger">@lang('Max 5 files can be uploaded. Maximum upload size is') {{ ini_get('upload_max_filesize') }}</span>
                                    </div>
                                    <div class="col-9">
                                        <div class="file-upload-wrapper" data-text="@lang('Select your file!')">
                                            <input type="file" name="attachments[]" id="inputAttachments"
                                            class="file-upload-field"/>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn--dark extraTicketAttachment ml-0"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div id="fileUploadsContainer"></div>
                                    </div>
                                    <div class="col-md-12 ticket-attachments-message text-muted mt-3">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-3">
                                <button class="btn btn--primary w-100 mt-4" type="submit" name="replayTicket" value="1"><i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                                </button>
                            </div>
                        </div>
                        
                    </form>


                    @foreach($messages as $message)
                        @if($message->admin_id == 0)

                            <div class="row border border--primary border-radius-3 my-3 mx-2">

                                <div class="col-md-3 border-end text-md-end text-start">
                                    <h5 class="my-3">{{ $ticket->name }}</h5>
                                    @if($ticket->user_id != null)
                                        <p><a href="{{route('admin.users.detail', $ticket->user_id)}}" >&#64;{{ $ticket->name }}</a></p>
                                    @else
                                        <p>@<span>{{$ticket->name}}</span></p>
                                    @endif
                                    <button class="btn btn-danger btn-sm my-3 confirmationBtn"
                                    data-question="@lang('Are you sure to delete this message?')"
                                    data-action="{{ route('admin.ticket.delete',$message->id)}}"
                                    ><i class="la la-trash"></i> @lang('Delete')</button>
                                </div>

                                <div class="col-md-9">
                                    <p class="text-muted fw-bold my-3">
                                        @lang('Posted on') {{ showDateTime($message->created_at, 'l, dS F Y @ H:i') }}</p>
                                    <p>{{ $message->message }}</p>
                                    @if($message->attachments->count() > 0)
                                        <div class="my-3">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="me-2"><i class="fa fa-file"></i> @lang('Attachment') {{++$k}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row border border-warning border-radius-3 my-3 mx-2 admin-bg-reply">

                                <div class="col-md-3 border-end text-md-end text-start">
                                    <h5 class="my-3">{{ @$message->admin->name }}</h5>
                                    <p class="lead text-muted">@lang('Staff')</p>
                                    <button class="btn btn-danger btn-sm my-3 confirmationBtn"
                                    data-question="@lang('Are you sure to delete this message?')"
                                    data-action="{{ route('admin.ticket.delete',$message->id)}}"
                                    ><i class="la la-trash"></i> @lang('Delete')</button>
                                </div>

                                <div class="col-md-9">
                                    <p class="text-muted fw-bold my-3">
                                        @lang('Posted on') {{showDateTime($message->created_at,'l, dS F Y @ H:i') }}</p>
                                    <p>{{ $message->message }}</p>
                                    @if($message->attachments->count() > 0)
                                        <div class="my-3">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="me-2"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                            </div>

                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Close Support Ticket!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you want to close this support ticket?')</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.close', $ticket->id) }}">
                        @csrf
                        <input type="hidden" name="replayTicket" value="2">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"> @lang('No') </button>
                        <button type="submit" class="btn btn--primary"> @lang('Yes') </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection




@push('breadcrumb-plugins')
    <a href="{{ route('admin.ticket') }}" class="btn btn-sm btn-outline--primary"><i class="la la-undo"></i> @lang('Back') </a>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            })
            var fileAdded = 0;
            $('.extraTicketAttachment').on('click',function(){
                if (fileAdded >= 4) {
                    notify('error','You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="row">
                        <div class="col-9 mb-3">
                            <div class="file-upload-wrapper" data-text="@lang('Select your file!')"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn--danger extraTicketAttachmentDelete"><i class="la la-times ml-0"></i></button>
                        </div>
                    </div>
                `)
            });

            $(document).on('click','.extraTicketAttachmentDelete',function(){
                fileAdded--;
                $(this).closest('.row').remove();
            });
        })(jQuery);
    </script>
@endpush
