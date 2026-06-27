<?php

return [

    /*
    |--------------------------------------------------------------------------
    | IAM Application Key
    |--------------------------------------------------------------------------
    |
    | This is the application key registered in IAM server. The access token
    | must contain this app_key in the payload for validation.
    |
    */
    'enabled' => env('IAM_ENABLED', false),

    'app_key' => env('IAM_APP_KEY', 'client-app'),

    /*
    |--------------------------------------------------------------------------
    | SSO Shared Secret
    |--------------------------------------------------------------------------
    |
    | Shared secret digunakan untuk verifikasi backchannel HMAC pada endpoint
    | /api/iam/sync-* dan /api/iam/push-roles. Disarankan menyimpan raw secret
    | di environment (IAM_SSO_SECRET) dan tidak menulis langsung ke repository.
    |
    */
    'sso_secret' => env('IAM_SSO_SECRET', env('SSO_SECRET', env('APP_KEY'))),

    /*
    |--------------------------------------------------------------------------
    | JWT Secret Key
    |--------------------------------------------------------------------------
    |
    | The secret key used to verify JWT tokens from IAM server.
    | This must match the secret configured in IAM server.
    |
    */
    'jwt_secret' => env('IAM_JWT_SECRET', 'change-me'),

    /*
    |--------------------------------------------------------------------------
    | JWT Algorithm and Leeway
    |--------------------------------------------------------------------------
    |
    | Algorithm used to sign JWTs (default HS256) and optional leeway (secs)
    |
    */
    'jwt_algorithm' => env('IAM_JWT_ALGORITHM', 'HS256'),
    'jwt_leeway' => (int) env('IAM_JWT_LEEWAY', 0),

    /*
    |--------------------------------------------------------------------------
    | Optional issuer / audience checks
    |--------------------------------------------------------------------------
    |
    | When set, the middleware will validate the token's `iss` / `aud` claims
    | against these configuration values.
    |
    */
    'issuer' => env('IAM_ISSUER', env('IAM_BASE_URL', null)),
    'audience' => env('IAM_AUDIENCE', null),

    /*
    |--------------------------------------------------------------------------
    | IAM Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your IAM server where users will be redirected for login.
    |
    */
    'base_url' => env('IAM_BASE_URL', 'http://localhost:8000'),

    /*
    |--------------------------------------------------------------------------
    | IAM Backchannel URL
    |--------------------------------------------------------------------------
    |
    | The internal base URL of your IAM server for server-to-server communication
    | (e.g. inside Docker network). If null, base_url is used.
    |
    */
    'backchannel_url' => env('IAM_BACKCHANNEL', null),

    /*
    |--------------------------------------------------------------------------
    | Token Verification Endpoint
    |--------------------------------------------------------------------------
    |
    | Optional explicit endpoint for JWT verification. When null, the package
    | will derive it from the IAM base URL (or backchannel URL).
    |
    */
    'verify_endpoint' => env('IAM_VERIFY_ENDPOINT', null),

    /*
    |--------------------------------------------------------------------------
    | User applications endpoint on IAM server
    |--------------------------------------------------------------------------
    |
    | This URL is used by the client package to fetch the currently
    | authenticated user's applications from IAM server.
    |
    */
    'user_applications_endpoint' => env('IAM_USER_APPLICATIONS_ENDPOINT', null),

    /*
    |--------------------------------------------------------------------------
    | User applications detail endpoint on IAM server
    |--------------------------------------------------------------------------
    |
    | This URL is used by the client package to fetch detailed application
    | metadata for the current user.
    |
    */
    'user_applications_detail_endpoint' => env('IAM_USER_APPLICATIONS_DETAIL_ENDPOINT', null),

    /*
    |--------------------------------------------------------------------------
    | Backchannel user applications endpoint
    |--------------------------------------------------------------------------
    |
    | Deprecated for switcher reads. Application switchers should use the
    | standard IAM detail endpoint so browser-accessible URLs remain the
    | source of truth. Kept only for backward compatibility with older setups.
    |
    */
    'backchannel_user_applications_endpoint' => env('IAM_BACKCHANNEL_USER_APPLICATIONS_ENDPOINT', null),

    /*
    |--------------------------------------------------------------------------
    | Default Web Guard SSO Routes
    |--------------------------------------------------------------------------
    |
    | Configure the routes for SSO login and callback endpoints.
    |
    */
    'login_route' => env('IAM_LOGIN_ROUTE', '/sso/login'),
    'callback_route' => env('IAM_CALLBACK_ROUTE', '/sso/callback'),

    /*
    |--------------------------------------------------------------------------
    | Default Redirect After Login
    |--------------------------------------------------------------------------
    |
    | Where to redirect users after successful SSO login.
    |
    */
    'default_redirect_after_login' => env('IAM_DEFAULT_REDIRECT', '/'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | The guard to use for authenticating users after SSO login.
    |
    */
    'guard' => env('IAM_GUARD', 'web'),

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The User model class used in your application.
    |
    */
    'user_model' => env('IAM_USER_MODEL', 'App\\Models\\User'),
    'application_model' => env('IAM_APPLICATION_MODEL', 'App\Domain\Iam\Models\Application'),
    /*
    |--------------------------------------------------------------------------
    | Session Preservation
    |--------------------------------------------------------------------------
    |
    | Preserve session ID during login (no regeneration).
    | Set to true for IAM compatibility, false for standard Laravel behavior.
    |
    */
    'preserve_session_id' => env('IAM_PRESERVE_SESSION_ID', true),

    /*
    |--------------------------------------------------------------------------
    | Replace session on SSO callback
    |--------------------------------------------------------------------------
    |
    | When true, an existing local session will be invalidated and replaced
    | with the SSO user if the incoming token represents a different user.
    |
    */
    'replace_session_on_callback' => env('IAM_REPLACE_SESSION_ON_CALLBACK', true),

    /*
    |--------------------------------------------------------------------------
    | User Field Mapping
    |--------------------------------------------------------------------------
    |
    | Map JWT token fields to user model columns.
    | Add any custom fields your application needs (nip, nik, employee_id, etc)
    |
    | Format: 'database_column' => 'jwt_field'
    |
    */
    'user_fields' => [
        'iam_id' => 'sub',        // Required: JWT sub maps to iam_id
        'name' => 'name',
        'NIK' => 'nip',           // RBV uses NIK, assuming IAM sends nip
    ],

    /*
    |--------------------------------------------------------------------------
    | Unit Kerja Synchronization
    |
    | These settings ensure client-side user unit kerja is synchronized
    | from IAM token payload.
    */
    'unit_kerja_field' => env('IAM_UNIT_KERJA_FIELD', 'unit_kerja'),
    'require_unit_kerja' => env('IAM_REQUIRE_UNIT_KERJA', false),
    'sync_unit_kerja' => env('IAM_SYNC_UNIT_KERJA', true),
    'unit_kerja_model' => env('IAM_UNIT_KERJA_MODEL', \Juniyasyos\IamClient\Models\UnitKerja::class),
    'roles_field' => env('IAM_ROLES_FIELD', 'roles'),

    /*
    |------------------------------------------------------------------------
    | Unit Kerja Synchronization
    |------------------------------------------------------------------------
    |
    | Controls Unit Kerja sync and push endpoints for backchannel
    | communication between IAM center and client applications.
    |
    */
    'unit_kerja' => [
        'sync' => [
            'active' => env('IAM_UNIT_KERJA_SYNC_ACTIVE', true),
        ],
        'push' => [
            'active' => env('IAM_UNIT_KERJA_PUSH_ACTIVE', true),
            'path' => env('IAM_UNIT_KERJA_PUSH_PATH', 'api/iam/push-unit-kerja'),
            'middleware' => env('IAM_UNIT_KERJA_PUSH_MIDDLEWARE', 'api') ? explode(',', env('IAM_UNIT_KERJA_PUSH_MIDDLEWARE', 'api')) : ['api'],
        ],
        /*
        |----------------------------------------------------------------------
        | Delete Behavior
        |----------------------------------------------------------------------
        |
        | 'soft' — deleted unit kerja stay trashed (soft delete)
        | 'force' — deleted unit kerja force deleted (hard delete)
        | Default: 'soft' (conservative: keep data recoverable)
        |
        */
        'delete_soft' => env('IAM_UNIT_KERJA_DELETE_SOFT', false),
        /*
        |----------------------------------------------------------------------
        | Pivot Delete Behavior
        |----------------------------------------------------------------------
        |
        | user_unit_kerja pivot always force deletes (no soft delete on pivot).
        | Controlled via IAM center when user or unit kerja is deleted.
        |
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Identifier Field
    |--------------------------------------------------------------------------
    |
    | Primary field to identify users (used in updateOrCreate).
    | Usually 'iam_id' or 'email'
    |
    */
    'identifier_field' => env('IAM_IDENTIFIER_FIELD', 'email'),

    /*
    |--------------------------------------------------------------------------
    | Role Synchronization
    |--------------------------------------------------------------------------
    |
    | Enable automatic role sync from IAM token to Spatie Permission
    |
    */
    /*
    |
    | Role Synchronization
    |
    */
    'sync_roles' => env('IAM_SYNC_ROLES', true),
    'role_guard_name' => env('IAM_ROLE_GUARD_NAME', 'web'),

    /*
    |------------------------------------------------------------------------
    | User Sync Endpoint
    |------------------------------------------------------------------------
    |
    | Toggle whether the `/api/iam/sync-users` route should be exposed.  Set
    | to `false` to disable the export endpoint entirely – requests from the
    | IAM server will be rejected and the route will not be registered.  This
    | can be used as a safety switch when you want to temporarily prevent
    | automated user synchronisation without modifying server configuration.
    |
    */
    'sync_users' => env('IAM_SYNC_USERS', true),

    /*
    |------------------------------------------------------------------------
    | Back-channel security toggle
    |------------------------------------------------------------------------
    |
    | Set this to `false` to disable verification entirely.  Useful during
    | development or when you just want the sync route to exist without any
    | HMAC/JWT checks.  The route itself can still be turned off with
    | `sync_users`.
    |
    */
    'backchannel_verify' => env('IAM_BACKCHANNEL_VERIFY', true),

    /*
    |------------------------------------------------------------------------
    | Back-channel authentication method
    |------------------------------------------------------------------------
    |
    | Controls how requests originating from the IAM server are authenticated
    | when they hit a client application's back‑channel endpoints (such as
    | `/api/iam/sync-users`).  The preferred value is `jwt`, which requires a
    | signed token to be included in the `Authorization: Bearer` header.
    | The legacy option `hmac` continues to verify an HMAC/sha256 using the
    | shared `sso.secret` value for compatibility with existing deployments.
    |
    */
    'backchannel_method' => env('IAM_BACKCHANNEL_METHOD', 'hmac'),

    /*
    |--------------------------------------------------------------------------
    | Role enforcement (optional)
    |--------------------------------------------------------------------------
    |
    | - `require_roles` when true will reject SSO login if the token contains
    |   no roles.
    | - `required_roles` accepts a comma-separated list (via env) or an array
    |   of role names; when non-empty the token must contain at least one of
    |   these roles for login to succeed.
    |
    */
    'require_roles' => env('IAM_REQUIRE_ROLES', false),
    'allow_roleless_sso' => env('IAM_ALLOW_ROLELESS_SSO', true),
    'require_access_profile' => env('IAM_REQUIRE_ACCESS_PROFILE', true),

    /*
    |------------------------------------------------------------------------
    | Role synchronization direction
    |------------------------------------------------------------------------
    |
    | `pull`: IAM pulls roles from client (`GET /api/iam/sync-roles`) (default)
    | `push`: IAM pushes roles into client (`POST /api/iam/push-roles`)
    |
    */
    'role_sync_mode' => env('IAM_ROLE_SYNC_MODE', 'pull'),

    /*
    |------------------------------------------------------------------------
    | User synchronization mode
    |------------------------------------------------------------------------
    |
    | Mode determines direction of user sync between IAM and IAM server.
    | * pull: IAM server pulls users from client (existing behavior)
    | * push: IAM server pushes users to client using /api/iam/push-users.
    */
    'user_sync_mode' => env('IAM_USER_SYNC_MODE', 'pull'),

    'user_sync_from_iam_allow_create' => env('IAM_USER_SYNC_FROM_IAM_ALLOW_CREATE', true),
    'user_sync_from_iam_delete_missing' => env('IAM_USER_SYNC_FROM_IAM_DELETE_MISSING', false),

    /*
    |------------------------------------------------------------------------
    | Role creation policy for incoming IAM role updates
    |------------------------------------------------------------------------
    |
    | When `role_sync_mode` is `push`, new roles are created only if this
    | setting is true. Default is false (update-only).
    |
    */
    'role_sync_from_iam_allow_create' => env('IAM_ROLE_SYNC_FROM_IAM_ALLOW_CREATE', false),

    'required_roles' => env('IAM_REQUIRED_ROLES') ? array_map('trim', explode(',', env('IAM_REQUIRED_ROLES'))) : [],

    /*
    |--------------------------------------------------------------------------
    | Store Access Token in Session
    |--------------------------------------------------------------------------
    |
    | Whether to store the IAM access token in the session after login.
    | This can be useful for making API calls to IAM server.
    |
    */
    'store_access_token_in_session' => env('IAM_STORE_TOKEN_IN_SESSION', true),

    /*
    |--------------------------------------------------------------------------
    | Verify token each request
    |--------------------------------------------------------------------------
    |
    | When enabled the client will call the IAM `verify` endpoint on every
    | web request to ensure the stored access token is still valid. If the
    | token is invalid the client will clear the session and redirect to
    | the login page.
    |
    */
    'verify_each_request' => env('IAM_VERIFY_EACH_REQUEST', true),
    /*
    --------------------------------------------------------------------------
    | Remote verify token each request
    --------------------------------------------------------------------------
    |
    | If true, after local JWT validation the client will call IAM `/api/sso/verify`
    | to ensure server-side session/token state has not been revoked or expired.
    |
    */
    'verify_remote_each_request' => env('IAM_VERIFY_REMOTE_EACH_REQUEST', false),
    /*
    |--------------------------------------------------------------------------
    | Auto‑attach verify middleware
    |--------------------------------------------------------------------------
    |
    | When `true` the package will automatically push its `iam.verify`
    | middleware into the application's `web` middleware group. Leave
    | `false` to register the middleware alias only and let the app add it
    | to Kernel manually.
    |
    */
    'attach_verify_middleware' => env('IAM_ATTACH_VERIFY_MIDDLEWARE', true),

    /*
    |--------------------------------------------------------------------------
    | Sync Session Lifetime with Token Expiry
    |--------------------------------------------------------------------------
    |
    | When enabled, session lifetime will be synced with token expiry time.
    | This ensures the session does not outlive the JWT token, preventing
    | scenarios where an expired token is still "active" in session.
    |
    */
    'sync_session_lifetime' => env('IAM_SYNC_SESSION_LIFETIME', true),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime Buffer (Minutes)
    |--------------------------------------------------------------------------
    |
    | Buffer subtracted from token TTL when calculating session lifetime.
    | Example: Token TTL 60 min - Buffer 2 min = Session lifetime 58 min.
    | This prevents edge cases where token expires mid-request.
    |
    */
    'session_lifetime_buffer' => (int) env('IAM_SESSION_LIFETIME_BUFFER', 2),

    /*
    |--------------------------------------------------------------------------
    | Auto‑attach session timeout enforcement middleware
    |--------------------------------------------------------------------------
    |
    | When `true` the package will automatically push `EnforceSessionTimeout`
    | middleware into the `web` group. This ensures sessions are forcefully
    | invalidated when token expires, even if user is idle.
    |
    */
    'attach_enforce_timeout_middleware' => env('IAM_ATTACH_ENFORCE_TIMEOUT_MIDDLEWARE', true),

    /*    |--------------------------------------------------------------------------
    | Logout Route Name
    |--------------------------------------------------------------------------
    |
    | The route name to redirect after logout.
    |
    */
    'logout_redirect_route' => env('IAM_LOGOUT_REDIRECT', 'home'),

    /*
    |--------------------------------------------------------------------------    | OP‑initiated logout behaviour
    --------------------------------------------------------------------------
    |
    | Controls how the client responds to OP‑initiated (front‑channel) logout
    | requests from the IAM server (`GET /iam/logout`). The package always
    | performs a full `auth()->logout()` and invalidates the session on
    | OP‑initiated logout. The legacy config key remains for compatibility.
    |
    */
    'logout_on_op_initiated' => true,

    /*
    --------------------------------------------------------------------------    | Login Route Name  
    |--------------------------------------------------------------------------
    |
    | The route name for login page (used for unauthenticated redirects).
    |
    */
    'login_route_name' => env('IAM_LOGIN_ROUTE_NAME', 'login'),

    /*
    |--------------------------------------------------------------------------
    | Guard Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Allows overriding guard and redirect specific settings per guard.
    | Values fall back to the legacy keys above for backwards
    | compatibility.
    |
    */
    'guards' => [
        'web' => [
            'guard' => env('IAM_GUARD', 'web'),
            'redirect_route' => env('IAM_DEFAULT_REDIRECT', '/'),
            'login_route_name' => env('IAM_LOGIN_ROUTE_NAME', 'login'),
            'logout_redirect_route' => env('IAM_LOGOUT_REDIRECT', 'home'),
        ],
    ],



];
