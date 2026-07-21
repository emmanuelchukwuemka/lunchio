<?php

namespace App\Support;

use App\Models\Deliverable;

/**
 * Defines the fixed checklist of deliverable "slots" a project (order) has,
 * based on the founder's package. Admin fills each slot, then sends the
 * whole batch to the founder in one action.
 */
class DeliverableChecklist
{
    public const KIND_FILE = 'file';
    public const KIND_WEBSITE = 'website';
    public const KIND_DOMAIN = 'domain';

    public const SLOTS = [
        'logo' => ['label' => 'Logo', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_LOGO],
        'brand_kit' => ['label' => 'Brand Kit', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_BRAND_PDF],
        'business_card' => ['label' => 'Business Card', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_BUSINESS_CARD],
        'website' => ['label' => 'Website', 'kind' => self::KIND_WEBSITE],
        'domain' => ['label' => 'Domain', 'kind' => self::KIND_DOMAIN],
        'registration_certificate' => ['label' => 'Registration Certificate', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_CAC_DOC],
        'social_media' => ['label' => 'Social Media Designs', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_SOCIAL_MEDIA],
        'content_plan' => ['label' => 'Content Plan', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_CONTENT_PLAN],
        'business_profile' => ['label' => 'Business Profile', 'kind' => self::KIND_FILE, 'type' => Deliverable::TYPE_BUSINESS_PROFILE],
    ];

    public const PACKAGE_SLOTS = [
        'starter' => ['logo', 'brand_kit', 'registration_certificate', 'social_media'],
        'pro' => ['logo', 'brand_kit', 'registration_certificate', 'social_media', 'website', 'domain', 'business_profile'],
        'premium' => ['logo', 'brand_kit', 'business_card', 'registration_certificate', 'social_media', 'website', 'domain', 'business_profile', 'content_plan'],
        'growth' => ['logo', 'brand_kit', 'business_card', 'registration_certificate', 'social_media', 'website', 'domain', 'business_profile', 'content_plan'],
    ];

    /**
     * Always shown regardless of package, so admin is never blocked from
     * attaching a website to a project (upsells, exceptions, one-offs).
     */
    public const ALWAYS_AVAILABLE = ['website', 'domain'];

    /**
     * @return array<string, array{label: string, kind: string, type?: string}>
     */
    public static function forPackage(?string $packageSlug): array
    {
        $keys = self::PACKAGE_SLOTS[$packageSlug] ?? array_keys(self::SLOTS);
        $keys = array_unique(array_merge($keys, self::ALWAYS_AVAILABLE));

        $slots = [];
        foreach ($keys as $key) {
            if (isset(self::SLOTS[$key])) {
                $slots[$key] = self::SLOTS[$key];
            }
        }

        return $slots;
    }
}
