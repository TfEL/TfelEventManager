//
//  calendarControl.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//

#import "calendarControl.h"

#import <EventKit/EventKit.h>

static EKEventStore *eventStore = nil;

@implementation calendarControl

+ (NSDate*)parseDate:(NSString*)inStrDate format:(NSString*)inFormat {
    NSDateFormatter* dtFormatter = [[NSDateFormatter alloc] init];
    [dtFormatter setLocale:[[NSLocale alloc] initWithLocaleIdentifier:@"en_AU"]];
    [dtFormatter setDateFormat:inFormat];
    NSDate* dateOutput = [dtFormatter dateFromString:inStrDate];
    return dateOutput;
}

+ (void)requestAccess:(void (^)(BOOL granted, NSError *error))callback;
{
    if (eventStore == nil) {
        eventStore = [[EKEventStore alloc] init];
    }
    // request permissions
    [eventStore requestAccessToEntityType:EKEntityTypeEvent completion:callback];
}

+ (BOOL)addEventAt:(NSDate*)eventDate withTitle:(NSString*)title inLocation:(NSString*)location
{
    EKEvent *event = [EKEvent eventWithEventStore:eventStore];
    EKCalendar *calendar = nil;
    NSString *calendarIdentifier = [[NSUserDefaults standardUserDefaults] valueForKey:@"TfEL Events"];
    
    // when identifier exists, my calendar probably already exists
    // note that user can delete my calendar. In that case I have to create it again.
    if (calendarIdentifier) {
        calendar = [eventStore calendarWithIdentifier:calendarIdentifier];
    }
    
    // calendar doesn't exist, create it and save it's identifier
    if (!calendar) {
        // http://stackoverflow.com/questions/7945537/add-a-new-calendar-to-an-ekeventstore-with-eventkit
        calendar = [EKCalendar calendarForEntityType:EKEntityTypeEvent eventStore:eventStore];
        
        // set calendar name. This is what users will see in their Calendar app
        [calendar setTitle:@"TfEL Events"];
        
        // find appropriate source type. I'm interested only in local calendars but
        // there are also calendars in iCloud, MS Exchange, ...
        // look for EKSourceType in manual for more options
        for (EKSource *s in eventStore.sources) {
            
            // I'm still running this here, becase at least we know there's SOME calendars....
            if ([[eventStore defaultCalendarForNewEvents] source]) {
                calendar.source = [[eventStore defaultCalendarForNewEvents] source];
            }
            
            /* We could probably handle local calendars manually (and that works with the final block, below).
            
            TODO: iCloud VS Local Detection
             
            if (s.sourceType == EKSourceTypeLocal) {
                NSLog(@"Local");
                calendar.source = s;
                break;
            } */
        }
        
        // save this in NSUserDefaults data for retrieval later
        NSString *calendarIdentifier = [calendar calendarIdentifier];
        
        NSError *error = nil;
        BOOL saved = [eventStore saveCalendar:calendar commit:YES error:&error];
        if (saved) {
            // http://stackoverflow.com/questions/1731530/whats-the-easiest-way-to-persist-data-in-an-iphone-app
            // saved successfuly, store it's identifier in NSUserDefaults
            [[NSUserDefaults standardUserDefaults] setObject:calendarIdentifier forKey:@"TfEL Events"];
            NSLog(@"Calendar Saved");
        } else {
            // unable to save calendar
            NSLog(@"Calendar Not Saved , %@", [error localizedDescription]);
            return NO;
        }
    }
    
    // this shouldn't happen
    if (!calendar) {
        NSLog(@"No calendar");
        return NO;
    }
    
    // assign basic information to the event; location is optional
    event.calendar = calendar;
    event.location = location;
    event.title = title;
    
    // set the start date to the current date/time and the event duration to two hours
    NSDate *startDate = eventDate;
    event.startDate = startDate;
    event.endDate = [startDate dateByAddingTimeInterval:3600 * 2];
    
    NSError *error = nil;
    // save event to the callendar
    BOOL result = [eventStore saveEvent:event span:EKSpanThisEvent commit:YES error:&error];
    if (result) {
        return YES;
    } else {
        // NSLog(@"Error saving event: %@", error);
        // unable to save event to the calendar
        return NO;
    }
}

@end
