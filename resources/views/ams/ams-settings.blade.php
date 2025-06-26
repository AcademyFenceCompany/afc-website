@extends('layouts.ams')

@section('content')
<div class="container-fluid p-4 py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-gear-fill me-2"></i>
                    <h5 class="mb-0">UI Settings</h5>
                </div>
                <div class="card-body p-3">
                    <form>
                        <!-- UI Mode Switch -->
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-layers-half me-2 text-secondary"></i>
                                <span>UI Mode</span>
                                <small class="text-muted d-block">Switch between Legacy and Modern UI</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="uiModeSwitch">
                                <label class="form-check-label" for="uiModeSwitch">Modern</label>
                            </div>
                        </div>
                        <!-- Font Size -->
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-type me-2 text-secondary"></i>
                                <span>Font Size</span>
                                <small class="text-muted d-block">Adjust the font size</small>
                            </div>
                            <select class="form-select w-auto" id="fontSizeSelect">
                                <option value="small">Small</option>
                                <option value="medium" selected>Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                        <!-- Layout Style -->
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-layout-sidebar-inset-reverse me-2 text-secondary"></i>
                                <span>Layout Style</span>
                                <small class="text-muted d-block">Choose your preferred layout</small>
                            </div>
                            <select class="form-select w-auto" id="layoutStyleSelect">
                                <option value="default" selected>Default</option>
                                <option value="compact">Compact</option>
                                <option value="spacious">Spacious</option>
                            </select>
                        </div>
                        <!-- Compact Mode -->
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-arrows-collapse me-2 text-secondary"></i>
                                <span>Compact Mode</span>
                                <small class="text-muted d-block">Reduce spacing for more content</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="compactModeSwitch">
                                <label class="form-check-label" for="compactModeSwitch">Enable</label>
                            </div>
                        </div>
                        <!-- Spacious Mode -->
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-arrows-expand me-2 text-secondary"></i>
                                <span>Spacious Mode</span>
                                <small class="text-muted d-block">Increase spacing for readability</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="spaciousModeSwitch">
                                <label class="form-check-label" for="spaciousModeSwitch">Enable</label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Icons CDN (if not already included) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection
