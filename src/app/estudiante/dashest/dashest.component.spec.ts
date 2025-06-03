import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashestComponent } from './dashest.component';

describe('DashestComponent', () => {
  let component: DashestComponent;
  let fixture: ComponentFixture<DashestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DashestComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DashestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
