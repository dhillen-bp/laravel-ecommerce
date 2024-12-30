<?php

namespace App\Livewire\Front;

use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Notification')]
class Notification extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $selectedNotifications = [];

    protected $listeners = [
        'notificationUpdated' => 'handleNotificationUpdated'
    ];

    public function mount()
    {
        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();
    }

    public function getNotifications()
    {
        return ModelsNotification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getUnreadCount()
    {
        return ModelsNotification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->whereNull('read_at')
            ->count();
    }

    public function handleNotificationUpdated()
    {
        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();
    }

    public function markAsRead($id)
    {
        $notification = ModelsNotification::find($id);
        if ($notification) {
            $notification->update(['read_at' => now()]);

            Toaster::success('Notifikasi ditandai telah dibaca.');
        }

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function markAllAsRead()
    {
        $notification =  ModelsNotification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        if ($notification) {
            $notification->update(['read_at' => now()]);

            Toaster::success('Notifikasi ditandai telah dibaca.');
        }

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function delete($id)
    {
        $notification = ModelsNotification::find($id);
        if ($notification) {
            $notification->delete();
            Toaster::success('Notifikasi berhasil dihapus.');
        }

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function render()
    {
        return view('livewire.front.notification');
    }
}
