@push('footer-scripts')
    <script>
        function addCommandListener(el) {
            el.addEventListener('click', function () {
                const element = el.parentNode.parentNode;

                element.parentNode.removeChild(element);
            });
        }

        document.querySelectorAll('.command-remove').forEach(function (el) {
            addCommandListener(el);
        });

        document.getElementById('addCommandButton').addEventListener('click', function () {
            let input = '<div class="input-group mb-2"><input type="text" name="commands[]" class="form-control"><div>';
            input += '<button class="btn btn-outline-danger command-remove" type="button"><i class="bi bi-x-lg"></i></button>';
            input += '</div></div>';

            const newElement = document.createElement('div');
            newElement.innerHTML = input;

            addCommandListener(newElement.querySelector('.command-remove'));

            document.getElementById('commands').appendChild(newElement);
        });
    </script>
@endpush

<div id="commands">

    @forelse($commands ?? [] as $command)
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="commands[]" value="{{ $command }}">
            <div>
                <button class="btn btn-outline-danger command-remove" type="button"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="commands[]">
            <div>
                <button class="btn btn-outline-danger command-remove" type="button"><i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    @endforelse
</div>

<small class="form-text">@lang('serveurminecraftvote::admin.rewards.commands-info')</small>

<div class="my-1">
    <button type="button" id="addCommandButton" class="btn btn-sm btn-success">
        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
    </button>
</div>
