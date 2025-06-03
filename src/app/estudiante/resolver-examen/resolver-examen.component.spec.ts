import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ResolverExamenComponent } from './resolver-examen.component';

describe('ResolverExamenComponent', () => {
  let component: ResolverExamenComponent;
  let fixture: ComponentFixture<ResolverExamenComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ResolverExamenComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ResolverExamenComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
