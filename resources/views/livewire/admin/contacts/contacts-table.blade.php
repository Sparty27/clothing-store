<div class="w-full">
    <div>
        <div role="tablist" class="tabs tabs-boxed max-w-xs">
            @foreach($this->tabs as $tab)
                <a role="tab" wire:click="selectTab('{{ $tab }}')" class="tab @if($selectedTab === $tab->value) tab-active @endif">{{ trans('contacts.'.$tab->value) }}</a>
            @endforeach
        </div>
    </div>

    <div>
        <div class="overflow-x-auto mt-6">
            <table class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>{{ trans('contacts.'.$selectedTab) }}</th>
                    <th>Активний</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->contacts as $contact)
                        <tr wire:key="{{ $contact->id }}">
                            <th>{{ $contact->id }}</th>
                            <td>{{ $contact->data[$contact->type->value] }}</td>
                            <td>
                                <div wire:key="contact-{{ $contact->id }}-active-{{ $contact->is_active }}">
                                    <input type="checkbox" class="toggle" @if($contact->is_active) checked @endif 
                                        wire:click.prevent="$dispatch('openModal', { 
                                            component: 'admin.modals.warning-modal', 
                                            arguments: { 
                                                dispatch: 'toggle-contact-active', 
                                                modelId: {{ $contact->id }} 
                                            } 
                                        })"/>
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-end items-center">
                                    <button class="btn btn-sm btn-success"
                                        wire:click="$dispatch('openModal', { 
                                        component: 'admin.modals.edit-contact-modal',
                                        arguments: {
                                            contact: '{{ $contact->id }}'
                                        }
                                        })">
                                        <i class="ri-pencil-line text-white"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
