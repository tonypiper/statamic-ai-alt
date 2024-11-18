<?php

namespace Vendor\StatamicAiAlt\Actions;

use Statamic\Actions\Action;
use Vendor\StatamicAiAlt\Jobs\GenerateAltTextJob;
use Statamic\Assets\Asset;

class GenerateAltText extends Action
{
    public static function title()
    {
        return 'Generate Alt Text';
    }

    public function visibleTo($item)
    {
        return $item instanceof Asset && $item->isImage();
    }

    public function authorize($user, $item)
    {
        return $user->can('edit', $item);
    }

    public function run($items, $values)
    {
        foreach ($items as $item) {
            if ($item instanceof Asset) {
                GenerateAltTextJob::dispatch($item->id());
            }
        }

        return ['message' => 'Alt text generation started'];
    }
}
