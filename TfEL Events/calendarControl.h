//
//  calendarControl.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 11/09/2014.
//

#import <Foundation/Foundation.h>

@interface calendarControl : NSObject

+ (void)requestAccess:(void (^)(BOOL granted, NSError *error))success;
+ (BOOL)addEventAt:(NSDate*)eventDate withTitle:(NSString*)title inLocation:(NSString*)location;
+ (NSDate*)parseDate:(NSString*)inStrDate format:(NSString*)inFormat;

@end
