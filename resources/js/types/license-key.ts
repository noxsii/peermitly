export type LicenseKeyStatus =
    | "pending"
    | "active"
    | "expired"
    | "revoked"
    | "blocked";

export type LicenseKeyGeneratorType = "uuid" | "random" | "pattern";

export type LicenseValidityUnit =
    | "days"
    | "weeks"
    | "months"
    | "years"
    | "lifetime";

export interface LicenseKey {
    uuid: string;
    key: string;
    status: LicenseKeyStatus;
    product: {
        uuid: string | null;
        name: string | null;
        slug: string | null;
    };
    customer: {
        uuid: string;
        email: string;
        name: string | null;
    } | null;
    type: {
        uuid: string | null;
        name: string | null;
    };
    validity_amount: number | null;
    validity_unit: LicenseValidityUnit;
    max_activations: number | null;
    requires_hwid_check: boolean;
    activated_at: string | null;
    expires_at: string | null;
    last_checked_at: string | null;
    check_count: number;
    revoked_at: string | null;
    revoked_reason: string | null;
    created_at: string | null;
}

export interface LicenseKeyType {
    uuid: string;
    name: string;
    description: string | null;
    generator_type: LicenseKeyGeneratorType;
    configuration: Record<string, unknown>;
    is_active: boolean;
    license_keys_count?: number;
    created_at: string | null;
    updated_at: string | null;
}

export interface ProductOption {
    uuid: string;
    name: string;
    slug: string;
    is_active: boolean;
}

export interface CustomerOption {
    uuid: string;
    email: string;
    name: string | null;
    company: string | null;
}
