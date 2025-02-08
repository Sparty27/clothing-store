<?php

namespace App\Livewire\Admin\Components;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Alert extends Component
{
    public $opened = false;

    public array $alerts;

    public function mount()
    {
        $this->alerts = [];

        if (session()->has('alert')) {
            switch (true) {
                case is_array(session()->get('alert')):
                    $data = session()->get('alert');
                    $this->open($data[0], $data[1] ?? null, $data[2] ?? null, $data[3] ?? null, $data[4] ?? null);
                    break;
                default:
                    $this->open(session()->get('alert'));
            }
        }
    }

    #[On('alert-open')] 
    public function open($text, $title = null, $style = null, $icon = null, $url = null)
    {
        $this->opened = true;

        $this->alerts [] = [
            'text' => $text,
            'title' => $title,
            'style' => $style,
            'url' => $url,
            'created' => now()->timestamp,
            'icon' => $icon,
        ];
    }

    public function close($key)
    {
        unset($this->alerts[$key]);

        if (count($this->alerts) == 0) {
            $this->opened = false;
        }
    }

    public function elapsedSeconds($timestamp)
    {
        return Carbon::createFromTimestamp($timestamp)->diffInSeconds(now());
    }


    public function update()
    {
        $keysToDel = [];
        foreach ($this->alerts as $key => $alert) {
            if ($this->elapsedSeconds($alert['created']) > 3) {
                $keysToDel [] = $key;
            }
        }

        foreach ($keysToDel as $key) {
            $this->close($key);
        }
    }

    public function btnClick($key)
    {
        if ($this->alerts[$key]['url'] ?? false) {
            return redirect($this->alerts[$key]['url']);
        } else {
            $this->close($key);
        }
    }
    
    public function render()
    {
        return view('livewire.admin.components.alert');
    }
}
