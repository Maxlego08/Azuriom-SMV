<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin\AdminController;
use Azuriom\Plugin\ServeurMinecraftVote\Models\WebhookReward;
use Azuriom\ServeurMinecraftVote\Vote\Requests\WebhookRewardRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class WebhookRewardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('vote::admin.rewards.webhooks.create', [
            'servers' => Server::executable()->get(),
            'webhooks' => AdminController::WEBHOOK_EVENTS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WebhookRewardRequest $request
     * @return RedirectResponse
     */
    public function store(WebhookRewardRequest $request): RedirectResponse
    {
        WebhookReward::create($request->validated());

        return redirect()->route('vote.admin.smv.index')
            ->with('success', trans('vote::admin.rewards.status.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WebhookReward $reward
     * @return Application|Factory|View
     */
    public function edit(WebhookReward $reward)
    {
        return view('vote::admin.rewards.webhooks.edit', [
            'reward' => $reward->load('server'),
            'servers' => Server::executable()->get(),
            'webhooks' => AdminController::WEBHOOK_EVENTS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WebhookRewardRequest $request
     * @param WebhookReward $reward
     * @return RedirectResponse
     */
    public function update(WebhookRewardRequest $request, WebhookReward $reward): RedirectResponse
    {
        $reward->update($request->validated());

        return redirect()->route('vote.admin.smv.index')
            ->with('success', trans('vote::admin.rewards.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WebhookReward $reward
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(WebhookReward $reward): RedirectResponse
    {
        $reward->delete();

        return redirect()->route('vote.admin.smv.index')
            ->with('success', trans('vote::admin.rewards.status.deleted'));
    }
}
