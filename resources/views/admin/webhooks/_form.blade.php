@csrf

<div class="mb-3">
    <label class="form-label" for="webhookSelect">{{ trans('serveurminecraftvote::admin.fields.webhook') }}</label>
    <select class="form-select @error('webhook') is-invalid @enderror" id="webhookSelect" name="webhook" required>
        @foreach($webhooks as $webhook)
            <option value="{{ $webhook }}" @if(($reward->webhook ?? '') === $webhook) selected @endif>{{ $webhook }}</option>
        @endforeach
    </select>
    <small>{!! trans('serveurminecraftvote::admin.webhook.info') !!}</small>

    @error('webhook')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $reward->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="serverSelect">{{ trans('serveurminecraftvote::admin.fields.server') }}</label>
    <select class="form-select @error('server_id') is-invalid @enderror" id="serverSelect" name="server_id" required>
        @foreach($servers as $server)
        <option value="{{ $server->id }}" @if(($reward->server_id ?? 0) === $server->id) selected @endif>{{ $server->name }}</option>
        @endforeach
    </select>

    @error('server_id')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="chancesInput">{{ trans('serveurminecraftvote::admin.fields.chances') }}</label>

    <div class="input-group">
        <input type="text" class="form-control @error('chances') is-invalid @enderror" id="chancesInput" name="chances" value="{{ old('chances', $reward->chances ?? '0') }}" required>
        <div class="input-group-append">
            <div class="input-group-text">%</div>
        </div>

        @error('chances')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="moneyInput">{{ trans('messages.fields.money') }}</label>

    <div class="input-group">
        <input type="text" class="form-control @error('money') is-invalid @enderror" id="moneyInput" name="money" value="{{ old('money', $reward->money ?? 0) }}">
        <div class="input-group-append">
            <div class="input-group-text">{{ money_name() }}</div>
        </div>

        @error('money')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="limitInput">{{ trans('serveurminecraftvote::admin.fields.limit') }}</label>

    <div class="input-group">
        <input type="text" class="form-control @error('limit') is-invalid @enderror" id="limitInput" name="limit" value="{{ old('limit', $reward->limit ?? 0) }}">

        @error('limit')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <small>{{ trans('serveurminecraftvote::admin.limit') }}</small>
</div>

<div class="mb-3 custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="needOnlineSwitch" name="need_online" @if(old('need_online', $reward->need_online ?? true)) checked @endif>
    <label class="custom-control-label" for="needOnlineSwitch">{{ trans('serveurminecraftvote::admin.rewards.need-online') }}</label>
</div>

<div class="mb-3">
    <label>{{ trans('serveurminecraftvote::admin.fields.commands') }}</label>
    @include('serveurminecraftvote::admin.elements.commands', ['commands' => $reward->commands ?? []])
</div>

<div class="mb-3 custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="enableSwitch" name="is_enabled" @if(old('is_enabled', $reward->is_enabled ?? true)) checked @endif>
    <label class="custom-control-label" for="enableSwitch">{{ trans('serveurminecraftvote::admin.rewards.enable') }}</label>
</div>
