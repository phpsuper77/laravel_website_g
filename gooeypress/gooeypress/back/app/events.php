<?php

Event::listen('workers.ScreenshotWasTaken', 'Gooeypress\EventHandlers\ScreenshotWasTakenHandler');

Event::listen('workers.YSlowWasObtained', 'Gooeypress\EventHandlers\YSlowWasObtainedHandler');

Event::listen('theme.ThemeBecameReady', 'Gooeypress\EventHandlers\ThemeBecameReadyHandler');
